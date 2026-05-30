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

            // Assign Test Schedule if accepted
            if ($status === 'dokumen_diterima') {
                $settings = $this->model('Settings_model');
                $start_date = $settings->getSetting('tes_start_date');
                $end_date = $settings->getSetting('tes_end_date');
                $quota = $settings->getSetting('tes_quota_per_day') ?: 20;
                
                $this->model('Pendaftaran_model')->assignJadwalTes($pendaftaran_id, $start_date, $end_date, $quota);
            }

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

    public function akunSiswa() {
        $db = new Database();
        $db->query("SELECT u.id as user_id, u.name, u.email, u.created_at, p.status 
                    FROM users u 
                    LEFT JOIN pendaftaran p ON u.id = p.user_id 
                    WHERE u.role = 'user' 
                    ORDER BY u.created_at DESC");
        $data['akun'] = $db->resultSet();
        $this->view('admin/kelola_akun', $data);
    }

    public function reset_password_akun() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_POST['user_id'];
            $new_password = $_POST['password'];
            $userModel = $this->model('User_model');
            $user = $userModel->getUserById($user_id);
            if ($user && !empty(trim($new_password))) {
                $userModel->updatePassword($user['email'], trim($new_password));
                header('Location: ' . base_url('admin/akunSiswa?success=reset_pass'));
                exit;
            }
        }
        header('Location: ' . base_url('admin/akunSiswa?error=not_found'));
        exit;
    }

    public function delete_akun($user_id) {
        $this->model('User_model')->deleteUser($user_id);
        header('Location: ' . base_url('admin/akunSiswa?success=deleted'));
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
        
        $data['kontak_alamat']  = $settings->getSetting('kontak_alamat')  ?? 'Jl. Raya Pagedangan - Legok RT 001/003 Desa Jatake, Kec. Pagedangan';
        $data['kontak_telepon'] = $settings->getSetting('kontak_telepon') ?? '(021) 1234-5678, 0812-3456-7890';
        $data['kontak_email']   = $settings->getSetting('kontak_email')   ?? 'info@misnurulikhlas.sch.id';
        
        $db = new Database();
        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status != 'belum_mendaftar'");
        $data['total_pendaftar'] = $db->single()['total'];

        $raw_release = $settings->getSetting('release_announcement_datetime');
        $data['release_datetime'] = !empty($raw_release) ? str_replace(' ', 'T', substr($raw_release, 0, 16)) : '';
        
        $data['panduan_ppdb'] = $settings->getSetting('panduan_ppdb');

        $data['tes_start_date']  = $settings->getSetting('tes_start_date')  ?? '';
        $data['tes_end_date']    = $settings->getSetting('tes_end_date')    ?? '';
        $data['tes_quota_per_day'] = $settings->getSetting('tes_quota_per_day') ?? 20;

        $data['jadwal'] = [];
        for ($g = 1; $g <= 3; $g++) {
            $data['jadwal'][] = [
                'gel'    => $settings->getSetting("jadwal_g{$g}_nama")   ?? "Gelombang $g",
                'daftar' => $settings->getSetting("jadwal_g{$g}_daftar") ?? '-',
                'sosial' => $settings->getSetting("jadwal_g{$g}_sosial") ?? '-',
                'hasil'  => $settings->getSetting("jadwal_g{$g}_hasil")  ?? '-',
                'daftar_ulang' => $settings->getSetting("jadwal_g{$g}_daftar_ulang") ?? '-',
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
            // Save Kontak
            if (isset($_POST['kontak_alamat'])) {
                $settings->updateSetting('kontak_alamat', trim($_POST['kontak_alamat']));
            }
            if (isset($_POST['kontak_telepon'])) {
                $settings->updateSetting('kontak_telepon', trim($_POST['kontak_telepon']));
            }
            if (isset($_POST['kontak_email'])) {
                $settings->updateSetting('kontak_email', trim($_POST['kontak_email']));
            }
            // Save release datetime
            if (isset($_POST['enable_release_schedule']) && !empty($_POST['release_announcement_datetime'])) {
                $datetime = str_replace('T', ' ', $_POST['release_announcement_datetime']) . ':00'; // Make YYYY-MM-DD HH:MM:SS
                $settings->updateSetting('release_announcement_datetime', $datetime);
            } else {
                $settings->updateSetting('release_announcement_datetime', ''); // clear
            }
            // Save Tes settings
            if (isset($_POST['tes_start_date'])) {
                $settings->updateSetting('tes_start_date', trim($_POST['tes_start_date']));
            }
            if (isset($_POST['tes_end_date'])) {
                $settings->updateSetting('tes_end_date', trim($_POST['tes_end_date']));
            }
            if (isset($_POST['tes_quota_per_day'])) {
                $settings->updateSetting('tes_quota_per_day', (int)$_POST['tes_quota_per_day']);
            }
            // Save jadwal
            for ($g = 1; $g <= 3; $g++) {
                foreach (['nama','daftar','sosial','hasil','daftar_ulang'] as $field) {
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

    public function upload_panduan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file_panduan'])) {
            $file = $_FILES['file_panduan'];
            if ($file['error'] == 0) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                if (strtolower($ext) == 'pdf') {
                    $uploadDir = '../public/uploads/panduan/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                    $filename = 'panduan_ppdb_' . time() . '.pdf';
                    if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                        $this->model('Settings_model')->updateSetting('panduan_ppdb', 'uploads/panduan/' . $filename);
                        header('Location: ' . base_url('admin/pengaturan?success=1'));
                        exit;
                    }
                }
            }
        }
        header('Location: ' . base_url('admin/pengaturan?error=1'));
        exit;
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

    public function jadwalTes() {
        $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : null;
        $data['jadwal'] = $this->model('Pendaftaran_model')->getJadwalTes($tanggal);
        $data['filter_tanggal'] = $tanggal;
        $this->view('admin/jadwal_tes', $data);
    }

    public function update_absensi() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];
            
            if ($this->model('Pendaftaran_model')->updateAbsensiTes($id, $status)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal mengubah absensi']);
            }
            exit;
        }
    }
    
    public function update_jadwal_date() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $tanggal = $_POST['tanggal'];
            if(empty($tanggal)) $tanggal = null;
            
            if ($this->model('Pendaftaran_model')->updateJadwalTesDate($id, $tanggal)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal mengubah jadwal tes']);
            }
            exit;
        }
    }
    public function laporan() {
        $db = new Database();
        
        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status = 'diterima'");
        $data['diterima'] = $db->single()['total'];

        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status = 'ditolak'");
        $data['ditolak'] = $db->single()['total'];

        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE absensi_tes = 'tidak_hadir'");
        $data['tidak_hadir'] = $db->single()['total'];

        $this->view('admin/laporan', $data);
    }

    public function exportLaporan($type) {
        $db = new Database();
        
        $where = "";
        $filename_prefix = "";
        
        if ($type === 'diterima') {
            $where = "p.status = 'diterima'";
            $filename_prefix = "Laporan_Siswa_Diterima";
        } elseif ($type === 'ditolak') {
            $where = "p.status = 'ditolak'";
            $filename_prefix = "Laporan_Siswa_Ditolak";
        } elseif ($type === 'tidak_hadir') {
            $where = "p.absensi_tes = 'tidak_hadir'";
            $filename_prefix = "Laporan_Siswa_Tidak_Hadir_Tes";
        } else {
            header('Location: ' . base_url('admin/laporan?error=1'));
            exit;
        }

        $db->query("SELECT p.id as pendaftaran_id, u.email, dp.nama_lengkap, dp.nisn, dp.tempat_lahir, dp.tanggal_lahir, dp.jenis_kelamin, dk.no_hp, dp.alamat_jalan as alamat 
                    FROM pendaftaran p 
                    JOIN users u ON p.user_id = u.id 
                    LEFT JOIN data_pribadi dp ON p.user_id = dp.user_id
                    LEFT JOIN data_kontak dk ON p.user_id = dk.user_id
                    WHERE $where
                    ORDER BY p.created_at DESC");
        
        $results = $db->resultSet();

        $format = isset($_GET['format']) ? $_GET['format'] : 'csv';

        if ($format === 'excel') {
            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=" . $filename_prefix . "_" . date('Ymd_His') . ".xls");
            
            echo '<table border="1">';
            echo '<tr><th>ID Pendaftaran</th><th>Email</th><th>Nama Lengkap</th><th>NISN</th><th>Tempat Lahir</th><th>Tanggal Lahir</th><th>Jenis Kelamin</th><th>No. HP</th><th>Alamat</th></tr>';
            foreach ($results as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['pendaftaran_id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['nama_lengkap']) . '</td>';
                echo '<td>\'' . htmlspecialchars($row['nisn']) . '</td>'; // prepend quote to prevent scientific notation in excel
                echo '<td>' . htmlspecialchars($row['tempat_lahir']) . '</td>';
                echo '<td>' . htmlspecialchars($row['tanggal_lahir']) . '</td>';
                echo '<td>' . htmlspecialchars($row['jenis_kelamin']) . '</td>';
                echo '<td>\'' . htmlspecialchars($row['no_hp']) . '</td>'; // prepend quote
                echo '<td>' . htmlspecialchars($row['alamat']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            exit;
        }

        // CSV format
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename_prefix . '_' . date('Ymd_His') . '.csv');
        $output = fopen('php://output', 'w');
        
        // Output CSV header
        fputcsv($output, ['ID Pendaftaran', 'Email', 'Nama Lengkap', 'NISN', 'Tempat Lahir', 'Tanggal Lahir', 'Jenis Kelamin', 'No. HP', 'Alamat']);
        
        foreach ($results as $row) {
            fputcsv($output, [
                $row['pendaftaran_id'], 
                $row['email'], 
                $row['nama_lengkap'], 
                $row['nisn'], 
                $row['tempat_lahir'], 
                $row['tanggal_lahir'], 
                $row['jenis_kelamin'], 
                $row['no_hp'], 
                $row['alamat']
            ]);
        }
        fclose($output);
        exit;
    }

    public function printLaporan($type) {
        $db = new Database();
        
        $where = "";
        $title = "";
        
        if ($type === 'diterima') {
            $where = "p.status = 'diterima'";
            $title = "LAPORAN SISWA DITERIMA (LULUS)";
        } elseif ($type === 'ditolak') {
            $where = "p.status = 'ditolak'";
            $title = "LAPORAN SISWA DITOLAK (TIDAK LULUS)";
        } elseif ($type === 'tidak_hadir') {
            $where = "p.absensi_tes = 'tidak_hadir'";
            $title = "LAPORAN SISWA TIDAK HADIR TES";
        } else {
            die('Invalid type');
        }

        $db->query("SELECT p.id as pendaftaran_id, u.email, dp.nama_lengkap, dp.nisn, dp.tempat_lahir, dp.tanggal_lahir, dp.jenis_kelamin, dk.no_hp, dp.alamat_jalan as alamat 
                    FROM pendaftaran p 
                    JOIN users u ON p.user_id = u.id 
                    LEFT JOIN data_pribadi dp ON p.user_id = dp.user_id
                    LEFT JOIN data_kontak dk ON p.user_id = dk.user_id
                    WHERE $where
                    ORDER BY p.created_at DESC");
        
        $data['title'] = $title;
        $data['results'] = $db->resultSet();

        $this->view('admin/print_laporan', $data);
    }
}
