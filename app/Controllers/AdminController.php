<?php
class AdminController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            header('Location: ' . base_url('auth'));
            exit;
        }
    }

    public function index() {
        $db = new Database();
        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status != 'belum_mendaftar'");
        $data['total'] = $db->single()['total'];
        
        $data['kuota'] = $this->model('Settings_model')->getSetting('kuota_pendaftaran') ?? 100;

        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status = 'nunggu_verifikasi'");
        $data['menunggu'] = $db->single()['total'];

        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status = 'dokumen_diterima'");
        $data['berkas_valid'] = $db->single()['total'];

        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status = 'diterima'");
        $data['diterima'] = $db->single()['total'];

        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status = 'ditolak'");
        $data['ditolak'] = $db->single()['total'];

        $db->query("SELECT p.*, dp.nama_lengkap as nama, dk.no_hp, u.email 
                    FROM pendaftaran p 
                    JOIN users u ON p.user_id = u.id 
                    LEFT JOIN data_pribadi dp ON p.user_id = dp.user_id
                    LEFT JOIN data_kontak dk ON p.user_id = dk.user_id
                    WHERE p.status != 'belum_mendaftar'
                    ORDER BY p.created_at DESC LIMIT 5");
        $data['latest'] = $db->resultSet();

        $this->view('admin/dashboard', $data);
    }

    public function pendaftar() {
        $db = new Database();
        $db->query("SELECT p.*, dp.nama_lengkap as nama, dk.no_hp, u.email 
                    FROM pendaftaran p 
                    JOIN users u ON p.user_id = u.id 
                    LEFT JOIN data_pribadi dp ON p.user_id = dp.user_id
                    LEFT JOIN data_kontak dk ON p.user_id = dk.user_id
                    WHERE p.status != 'belum_mendaftar'
                    ORDER BY p.created_at DESC");
        $data['pendaftar'] = $db->resultSet();
        $this->view('admin/data_pendaftar', $data);
    }

    public function detail($id) {
        $db = new Database();
        
        $db->query("SELECT p.*, u.email FROM pendaftaran p JOIN users u ON p.user_id = u.id WHERE p.id = :id");
        $db->bind('id', $id);
        $data['pendaftaran'] = $db->single();
        
        if (!$data['pendaftaran']) {
            header('Location: ' . base_url('admin/pendaftar'));
            exit;
        }

        $uid = $data['pendaftaran']['user_id'];
        
        $data['pribadi']  = $this->model('DataPribadi_model')->getByUserId($uid);
        $data['ayah']     = $this->model('DataAyah_model')->getByUserId($uid);
        $data['ibu']      = $this->model('DataIbu_model')->getByUserId($uid);
        $data['wali']     = $this->model('DataWali_model')->getByUserId($uid);
        $data['kontak']   = $this->model('DataKontak_model')->getByUserId($uid);
        $data['periodik'] = $this->model('DataPeriodik_model')->getByUserId($uid);
        $data['dokumen']  = $this->model('Dokumen_model')->getByUserId($uid);

        $this->view('admin/verifikasi_berkas', $data);
    }

    public function update_status() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $status = $_POST['status'];
            $catatan = $_POST['catatan'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
            $revisi_json = null;

            if ($status === 'perlu_revisi' && isset($_POST['revisi_items'])) {
                $revisi_items = $_POST['revisi_items'];
                $revisi_arr = [];
                foreach ($revisi_items as $item) {
                    $note_key = 'revisi_note_' . $item;
                    $revisi_arr[$item] = isset($_POST[$note_key]) ? trim($_POST[$note_key]) : '';
                }
                $revisi_json = json_encode($revisi_arr);
            }

            $this->model('Pendaftaran_model')->updateStatus($status, $catatan, $pendaftaran_id, $revisi_json);
            header('Location: ' . base_url('admin/detail/' . $pendaftaran_id . '?success=1'));
            exit;
        }
    }

    public function reset_password_pendaftar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_POST['user_id'];
            $new_password = $_POST['password'];
            $userModel = $this->model('User_model');
            $user = $userModel->getUserById($user_id);
            if ($user && !empty(trim($new_password))) {
                $userModel->updatePassword($user['email'], trim($new_password));
                header('Location: ' . base_url('admin/pendaftar?success=reset_pass'));
                exit;
            }
        }
        header('Location: ' . base_url('admin/pendaftar?error=not_found'));
        exit;
    }

    public function delete_pendaftar($user_id) {
        $this->model('User_model')->deleteUser($user_id);
        header('Location: ' . base_url('admin/pendaftar?success=deleted'));
        exit;
    }

    public function pengaturan() {
        $settings = $this->model('Settings_model');
        $data['kuota']           = $settings->getSetting('kuota_pendaftaran') ?? 100;
        $data['gelombang_aktif'] = $settings->getSetting('gelombang_aktif') ?? 1;
        
        $data['stats_siswa']      = $settings->getSetting('stats_siswa')      ?? '250+';
        $data['stats_guru']       = $settings->getSetting('stats_guru')       ?? '15+';
        $data['stats_eskul']      = $settings->getSetting('stats_eskul')      ?? '8+';
        $data['stats_akreditasi'] = $settings->getSetting('stats_akreditasi') ?? 'BAIK';
        
        $db = new Database();
        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status != 'belum_mendaftar'");
        $data['total_pendaftar'] = $db->single()['total'];

        $raw_release = $settings->getSetting('release_announcement_datetime');
        $data['release_datetime'] = !empty($raw_release) ? str_replace(' ', 'T', substr($raw_release, 0, 16)) : '';

        $data['jadwal'] = [];
        for ($g = 1; $g <= 3; $g++) {
            $data['jadwal'][] = [
                'gel'    => $settings->getSetting("jadwal_g{$g}_nama")   ?? "Gelombang $g",
                'daftar' => $settings->getSetting("jadwal_g{$g}_daftar") ?? '-',
                'sosial' => $settings->getSetting("jadwal_g{$g}_sosial") ?? '-',
                'hasil'  => $settings->getSetting("jadwal_g{$g}_hasil")  ?? '-',
            ];
        }
        
        $this->view('admin/pengaturan', $data);
    }

    public function update_pengaturan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $settings = $this->model('Settings_model');
            // Save kuota
            if (isset($_POST['kuota_pendaftaran'])) {
                $settings->updateSetting('kuota_pendaftaran', (int)$_POST['kuota_pendaftaran']);
            }
            // Save gelombang aktif
            if (isset($_POST['gelombang_aktif'])) {
                $settings->updateSetting('gelombang_aktif', (int)$_POST['gelombang_aktif']);
            }
            // Save stats
            if (isset($_POST['stats_siswa'])) {
                $settings->updateSetting('stats_siswa', trim($_POST['stats_siswa']));
            }
            if (isset($_POST['stats_guru'])) {
                $settings->updateSetting('stats_guru', trim($_POST['stats_guru']));
            }
            if (isset($_POST['stats_eskul'])) {
                $settings->updateSetting('stats_eskul', trim($_POST['stats_eskul']));
            }
            if (isset($_POST['stats_akreditasi'])) {
                $settings->updateSetting('stats_akreditasi', trim($_POST['stats_akreditasi']));
            }
            // Save release datetime
            if (isset($_POST['enable_release_schedule']) && !empty($_POST['release_announcement_datetime'])) {
                $datetime = str_replace('T', ' ', $_POST['release_announcement_datetime']) . ':00'; // Make YYYY-MM-DD HH:MM:SS
                $settings->updateSetting('release_announcement_datetime', $datetime);
            } else {
                $settings->updateSetting('release_announcement_datetime', ''); // clear
            }
            // Save jadwal
            for ($g = 1; $g <= 3; $g++) {
                foreach (['nama','daftar','sosial','hasil'] as $field) {
                    $key = "jadwal_g{$g}_{$field}";
                    if (isset($_POST[$key])) {
                        $settings->updateSetting($key, trim($_POST[$key]));
                    }
                }
            }
            header('Location: ' . base_url('admin/pengaturan?success=1'));
            exit;
        }
    }

    public function admins() {
        $data['admins'] = $this->model('User_model')->getAdmins();
        $this->view('admin/kelola_admin', $data);
    }

    public function add_admin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User_model');

            if ($userModel->getUserByEmail($_POST['email'])) {
                header('Location: ' . base_url('admin/admins?error=exists'));
                exit;
            }

            $userModel->createAdmin([
                'name'     => trim($_POST['name']),
                'email'    => trim($_POST['email']),
                'password' => $_POST['password'],
            ]);

            header('Location: ' . base_url('admin/admins?success=added'));
            exit;
        }
    }

    public function delete_admin($id) {
        // Prevent self-deletion
        if ($id == $_SESSION['user_id']) {
            header('Location: ' . base_url('admin/admins?error=self'));
            exit;
        }
        $this->model('User_model')->deleteUser($id);
        header('Location: ' . base_url('admin/admins?success=deleted'));
        exit;
    }
}
