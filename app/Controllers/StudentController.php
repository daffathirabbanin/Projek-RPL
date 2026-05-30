<?php
class StudentController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'user') {
            header('Location: ' . base_url('auth'));
            exit;
        }
    }

    private function syncNotifSession() {
        $uid = $_SESSION['user_id'];
        $pendaftaran = $this->getAdjustedPendaftaran($uid);
        $_SESSION['reg_status']  = $pendaftaran['status']  ?? 'belum_mendaftar';
        $_SESSION['reg_catatan'] = $pendaftaran['catatan'] ?? '';
        $_SESSION['revisi_json'] = ($pendaftaran['status'] ?? '') == 'perlu_revisi' ? ($pendaftaran['revisi_json'] ?? '') : '';
    }

    private function isEditable() {
        $uid = $_SESSION['user_id'];
        $pendaftaran = $this->model('Pendaftaran_model')->getByUserId($uid);
        if (!$pendaftaran) return true;
        $status = $pendaftaran['status'] ?? 'belum_mendaftar';
        return in_array($status, ['belum_mendaftar', 'perlu_revisi']);
    }

    private function initAllModels() {
        $uid = $_SESSION['user_id'];
        foreach (['DataPribadi_model','DataAyah_model','DataIbu_model','DataWali_model','DataKontak_model','DataPeriodik_model','Dokumen_model','Pendaftaran_model'] as $m) {
            $this->model($m)->init($uid);
        }
    }

    public function index() {
        $uid = $_SESSION['user_id'];
        $this->initAllModels();
        $this->syncNotifSession();
        $data['pendaftaran'] = $this->getAdjustedPendaftaran($uid);
        
        $pribadi = $this->model('DataPribadi_model')->getByUserId($uid);
        $ayah = $this->model('DataAyah_model')->getByUserId($uid);
        $ibu = $this->model('DataIbu_model')->getByUserId($uid);
        $kontak = $this->model('DataKontak_model')->getByUserId($uid);
        $periodik = $this->model('DataPeriodik_model')->getByUserId($uid);
        $dokumen = $this->model('Dokumen_model')->getByUserId($uid);
        $data['pribadi'] = $pribadi;

        $total_sections = 6;
        $filled_sections = 0;
        if (!empty(trim($pribadi['nama_lengkap'] ?? ''))) $filled_sections++;
        if (!empty(trim($ayah['nama_ayah'] ?? ''))) $filled_sections++;
        if (!empty(trim($ibu['nama_ibu'] ?? ''))) $filled_sections++;
        if (!empty(trim($kontak['notlp_rumah'] ?? '')) || !empty(trim($kontak['no_hp'] ?? ''))) $filled_sections++;
        if (!empty(trim($periodik['tinggi_badan'] ?? ''))) $filled_sections++;
        if (!empty(trim($dokumen['kk'] ?? '')) || !empty(trim($dokumen['akta'] ?? ''))) $filled_sections++;
        
        $data['progress_percent'] = round(($filled_sections / $total_sections) * 100);

        $settings = $this->model('Settings_model');
        $active_gel = $settings->getSetting('gelombang_aktif') ?? 1;
        $data['jadwal_daftar'] = $settings->getSetting("jadwal_g{$active_gel}_daftar") ?? 'Belum ditentukan';
        
        $jadwal = $data['pendaftaran']['jadwal_tes'] ?? null;
        if ($jadwal) {
            // Format to Indonesian date (e.g., 01 Juli 2026)
            $months = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
            $parts = explode('-', $jadwal);
            if (count($parts) === 3) {
                $data['jadwal_tes'] = $parts[2] . ' ' . $months[$parts[1]] . ' ' . $parts[0];
            } else {
                $data['jadwal_tes'] = $jadwal;
            }
        } else {
            $data['jadwal_tes'] = 'Menunggu Info Admin';
        }
        
        $this->view('student/dashboard', $data);
    }

    public function form() {
        $uid = $_SESSION['user_id'];
        $this->initAllModels();
        $this->syncNotifSession();
        
        if (!$this->isEditable()) {
            header('Location: ' . base_url('student?error=not_editable'));
            exit;
        }
        
        $data['pribadi']  = $this->model('DataPribadi_model')->getByUserId($uid);
        $data['ayah']     = $this->model('DataAyah_model')->getByUserId($uid);
        $data['ibu']      = $this->model('DataIbu_model')->getByUserId($uid);
        $data['wali']     = $this->model('DataWali_model')->getByUserId($uid);
        $data['kontak'] = $this->model('DataKontak_model')->getByUserId($uid);
        $data['periodik'] = $this->model('DataPeriodik_model')->getByUserId($uid);
        $data['dokumen'] = $this->model('Dokumen_model')->getByUserId($uid);
        
        $this->view('student/form_wizard', $data);
    }

    // AJAX autosave endpoints
    public function save_pribadi() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->isEditable()) {
                echo json_encode(['status' => 'error', 'message' => 'Data tidak dapat diubah']);
                exit;
            }
            $ok = $this->model('DataPribadi_model')->save($_POST, $_SESSION['user_id']);
            echo json_encode(['status' => $ok ? 'success' : 'error']);
        }
    }
    public function save_ayah() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->isEditable()) {
                echo json_encode(['status' => 'error', 'message' => 'Data tidak dapat diubah']);
                exit;
            }
            $ok = $this->model('DataAyah_model')->save($_POST, $_SESSION['user_id']);
            echo json_encode(['status' => $ok ? 'success' : 'error']);
        }
    }
    public function save_ibu() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->isEditable()) {
                echo json_encode(['status' => 'error', 'message' => 'Data tidak dapat diubah']);
                exit;
            }
            $ok = $this->model('DataIbu_model')->save($_POST, $_SESSION['user_id']);
            echo json_encode(['status' => $ok ? 'success' : 'error']);
        }
    }
    public function save_wali() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->isEditable()) {
                echo json_encode(['status' => 'error', 'message' => 'Data tidak dapat diubah']);
                exit;
            }
            $ok = $this->model('DataWali_model')->save($_POST, $_SESSION['user_id']);
            echo json_encode(['status' => $ok ? 'success' : 'error']);
        }
    }
    public function save_kontak_periodik() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->isEditable()) {
                echo json_encode(['status' => 'error', 'message' => 'Data tidak dapat diubah']);
                exit;
            }
            $ok1 = $this->model('DataKontak_model')->save($_POST, $_SESSION['user_id']);
            $ok2 = $this->model('DataPeriodik_model')->save($_POST, $_SESSION['user_id']);
            echo json_encode(['status' => ($ok1 && $ok2) ? 'success' : 'error']);
        }
    }

    public function save_upload_ajax() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->isEditable()) {
                echo json_encode(['status' => 'error', 'message' => 'Data tidak dapat diubah']);
                exit;
            }
            $fields = ['ijazah', 'kk', 'akta', 'foto_3x4'];
            $has_error = false;
            $error_msg = '';

            foreach ($fields as $field) {
                if (isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
                    $file = $_FILES[$field];
                    
                    if ($file['error'] !== UPLOAD_ERR_OK) {
                        $has_error = true;
                        $error_msg = 'Upload gagal untuk ' . $field;
                        continue;
                    }

                    $allowed = [];
                    if ($field === 'foto_3x4') {
                        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
                    } else if (in_array($field, ['kk', 'akta', 'ijazah'])) {
                        $allowed = ['application/pdf'];
                    }

                    if (empty($allowed) || !in_array($file['type'], $allowed)) {
                        $has_error = true;
                        $error_msg = 'Format ' . $field . ' tidak valid.';
                        continue;
                    }

                    if ($file['size'] > 2 * 1024 * 1024) {
                        $has_error = true;
                        $error_msg = 'Ukuran file ' . $field . ' terlalu besar (Max 2MB).';
                        continue;
                    }

                    $dir = '../public/uploads/dokumen/';
                    if (!is_dir($dir)) mkdir($dir, 0777, true);

                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filename = $_SESSION['user_id'] . '_' . $field . '_' . time() . '.' . $ext;
                    if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                        $this->model('Dokumen_model')->saveField($field, 'uploads/dokumen/' . $filename, $_SESSION['user_id']);
                    } else {
                        $has_error = true;
                        $error_msg = 'Gagal menyimpan file ' . $field;
                    }
                }
            }

            if ($has_error) {
                echo json_encode(['status' => 'error', 'message' => $error_msg]);
            } else {
                echo json_encode(['status' => 'success']);
            }
        }
    }

    public function submit_form() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->isEditable()) {
                header('Location: ' . base_url('student?error=not_editable'));
                exit;
            }
            $uid = $_SESSION['user_id'];
            $pribadi = $this->model('DataPribadi_model')->getByUserId($uid);
            $ayah = $this->model('DataAyah_model')->getByUserId($uid);
            $ibu = $this->model('DataIbu_model')->getByUserId($uid);
            $kontak = $this->model('DataKontak_model')->getByUserId($uid);
            $periodik = $this->model('DataPeriodik_model')->getByUserId($uid);
            $dokumen = $this->model('Dokumen_model')->getByUserId($uid);
            $wali = $this->model('DataWali_model')->getByUserId($uid);

            // Cek status pengisian penanggung jawab
            $has_ayah = trim($ayah['nama_ayah'] ?? '') !== '' && trim($ayah['nama_ayah'] ?? '') !== '-';
            $has_ibu = trim($ibu['nama_ibu'] ?? '') !== '' && trim($ibu['nama_ibu'] ?? '') !== '-';
            $has_ortu = $has_ayah || $has_ibu;
            $has_wali = trim($wali['nama_wali'] ?? '') !== '' && trim($wali['nama_wali'] ?? '') !== '-';

            // Kalo kolom orang tua di isi wali ga bisa dikirim
            if ($has_ortu && $has_wali) {
                header('Location: ' . base_url('student/form?error=conflict_wali'));
                exit;
            }

            // Kalo kolom orang tua engga, wali engga juga -> tidak bisa dikirim
            if (!$has_ortu && !$has_wali) {
                header('Location: ' . base_url('student/form?error=no_parent_wali'));
                exit;
            }

            $is_incomplete = false;
            $missing_field = '';
            $required = [
                // Pribadi
                'nama_lengkap' => $pribadi['nama_lengkap']??'', 'jenis_kelamin' => $pribadi['jenis_kelamin']??'', 'nisn' => $pribadi['nisn']??'', 'nik' => $pribadi['nik']??'', 'no_kk' => $pribadi['no_kk']??'',
                'tempat_lahir' => $pribadi['tempat_lahir']??'', 'tanggal_lahir' => $pribadi['tanggal_lahir']??'', 'kewarganegaraan' => $pribadi['kewarganegaraan']??'', 'alamat_jalan' => $pribadi['alamat_jalan']??'',
                'rt' => $pribadi['rt']??'', 'rw' => $pribadi['rw']??'', 'kelurahan' => $pribadi['kelurahan']??'',
                'kode_pos' => $pribadi['kode_pos']??'',

                // Kontak & Periodik
                'notlp_rumah' => $kontak['notlp_rumah']??'', 'no_hp' => $kontak['no_hp']??'',
                'tinggi_badan' => $periodik['tinggi_badan']??'', 'berat_badan' => $periodik['berat_badan']??'', 'jarak_tempat_tinggal' => $periodik['jarak_tempat_tinggal']??'', 'jarak_km' => $periodik['jarak_km']??'',
                'waktu_jam' => $periodik['waktu_jam']??'', 'waktu_menit' => $periodik['waktu_menit']??'', 'jumlah_saudara_kandung' => $periodik['jumlah_saudara_kandung']??'',
                
                // Upload Dokumen
                'kk' => $dokumen['kk']??'', 'akta' => $dokumen['akta']??'', 'foto_3x4' => $dokumen['foto_3x4']??''
            ];
            
            foreach ($required as $key => $val) {
                if (trim($val) === '') {
                    $is_incomplete = true;
                    $missing_field = $key;
                    break;
                }
            }

            if ($is_incomplete) {
                header('Location: ' . base_url('student/form?error=incomplete&f='.$missing_field));
                exit;
            }

            $this->model('Pendaftaran_model')->submit($uid);
            header('Location: ' . base_url('student/dashboard?success=form_submitted'));
            exit;
        }
    }

    public function upload() {
        $uid = $_SESSION['user_id'];
        $this->initAllModels();
        $this->syncNotifSession();
        
        if (!$this->isEditable()) {
            header('Location: ' . base_url('student?error=not_editable'));
            exit;
        }
        
        $data['dokumen']     = $this->model('Dokumen_model')->getByUserId($uid);
        $data['pendaftaran'] = $this->getAdjustedPendaftaran($uid);
        $this->view('student/upload_dokumen', $data);
    }

    public function upload_process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->isEditable()) {
                header('Location: ' . base_url('student?error=not_editable'));
                exit;
            }
            $fields = ['ijazah', 'kk', 'akta', 'foto_3x4'];
            $uploaded_count = 0;
            $has_error = false;
            $error_msg = '';

            foreach ($fields as $field) {
                if (isset($_FILES[$field]) && $_FILES[$field]['error'] !== UPLOAD_ERR_NO_FILE) {
                    $file = $_FILES[$field];
                    
                    if ($file['error'] !== UPLOAD_ERR_OK) {
                        $has_error = true;
                        if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
                            $error_msg = 'size_invalid';
                        } else {
                            $error_msg = 'failed';
                        }
                        continue;
                    }

                    $allowed = [];
                    if ($field === 'foto_3x4') {
                        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
                    } else if (in_array($field, ['kk', 'akta', 'ijazah'])) {
                        $allowed = ['application/pdf'];
                    }

                    if (empty($allowed) || !in_array($file['type'], $allowed)) {
                        $has_error = true;
                        $error_msg = 'format_invalid';
                        continue;
                    }

                    if ($file['size'] > 2 * 1024 * 1024) {
                        $has_error = true;
                        $error_msg = 'size_invalid';
                        continue;
                    }

                    $dir = '../public/uploads/dokumen/';
                    if (!is_dir($dir)) mkdir($dir, 0777, true);

                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filename = $_SESSION['user_id'] . '_' . $field . '_' . time() . '.' . $ext;
                    if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
                        $this->model('Dokumen_model')->saveField($field, 'uploads/dokumen/' . $filename, $_SESSION['user_id']);
                        $uploaded_count++;
                    } else {
                        $has_error = true;
                        $error_msg = 'failed';
                    }
                }
            }

            if ($has_error) {
                if ($error_msg == 'format_invalid') {
                    header('Location: ' . base_url('student/upload?error=invalid'));
                } elseif ($error_msg == 'size_invalid') {
                    header('Location: ' . base_url('student/upload?error=oversize'));
                } else {
                    header('Location: ' . base_url('student/upload?error=failed'));
                }
            } else {
                header('Location: ' . base_url('student/upload?success=1'));
            }
            exit;
        }
    }

    public function cetak() {
        $uid = $_SESSION['user_id'];
        $data['pribadi']     = $this->model('DataPribadi_model')->getByUserId($uid);
        $data['ayah']        = $this->model('DataAyah_model')->getByUserId($uid);
        $data['ibu']         = $this->model('DataIbu_model')->getByUserId($uid);
        $data['wali']        = $this->model('DataWali_model')->getByUserId($uid);
        $data['kontak']      = $this->model('DataKontak_model')->getByUserId($uid);
        $data['periodik']    = $this->model('DataPeriodik_model')->getByUserId($uid);
        $data['pendaftaran'] = $this->getAdjustedPendaftaran($uid);
        $data['dokumen']     = $this->model('Dokumen_model')->getByUserId($uid);
        if ($data['pendaftaran']['status'] == 'belum_mendaftar') {
            header('Location: ' . base_url('student'));
            exit;
        }
        $jadwal = $data['pendaftaran']['jadwal_tes'] ?? null;
        if ($jadwal) {
            $months = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
            $parts = explode('-', $jadwal);
            if (count($parts) === 3) {
                $data['jadwal_tes_formatted'] = $parts[2] . ' ' . $months[$parts[1]] . ' ' . $parts[0];
            } else {
                $data['jadwal_tes_formatted'] = $jadwal;
            }
        } else {
            $data['jadwal_tes_formatted'] = '-';
        }
        
        $this->view('student/cetak_kartu', $data);
    }

    public function pengumuman() {
        $uid = $_SESSION['user_id'];
        $this->syncNotifSession();
        $data['pendaftaran'] = $this->getAdjustedPendaftaran($uid);
        $data['pribadi']     = $this->model('DataPribadi_model')->getByUserId($uid);
        
        $jadwal = $data['pendaftaran']['jadwal_tes'] ?? null;
        if ($jadwal) {
            $months = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
            $parts = explode('-', $jadwal);
            if (count($parts) === 3) {
                $data['jadwal_tes'] = $parts[2] . ' ' . $months[$parts[1]] . ' ' . $parts[0];
            } else {
                $data['jadwal_tes'] = $jadwal;
            }
        } else {
            $data['jadwal_tes'] = 'Menunggu Info Admin';
        }
        
        $this->view('student/pengumuman', $data);
    }

    public function cetak_surat() {
        $uid = $_SESSION['user_id'];
        $data['pendaftaran'] = $this->getAdjustedPendaftaran($uid);

        // Hanya siswa berstatus 'diterima' yang bisa akses
        if (($data['pendaftaran']['status'] ?? '') !== 'diterima') {
            header('Location: ' . base_url('student'));
            exit;
        }

        $data['pribadi']  = $this->model('DataPribadi_model')->getByUserId($uid);
        $data['ayah']     = $this->model('DataAyah_model')->getByUserId($uid);
        $data['ibu']      = $this->model('DataIbu_model')->getByUserId($uid);
        $data['kontak']   = $this->model('DataKontak_model')->getByUserId($uid);

        $this->view('student/cetak_surat_penerimaan', $data);
    }

    private function getAdjustedPendaftaran($uid) {
        $pendaftaran = $this->model('Pendaftaran_model')->getByUserId($uid);
        if (!$pendaftaran) return null;
        
        $release_time = $this->model('Settings_model')->getSetting('release_announcement_datetime');
        $is_released = true;
        if (!empty($release_time)) {
            $is_released = time() >= strtotime($release_time);
        }
        
        if (!$is_released && in_array($pendaftaran['status'], ['diterima', 'ditolak'])) {
            $pendaftaran['status'] = 'nunggu_pengumuman';
        }
        return $pendaftaran;
    }

    public function kirim_ulang_pendaftaran() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uid = $_SESSION['user_id'];
            $this->model('Pendaftaran_model')->resubmit($uid);
            header('Location: ' . base_url('student?success=resubmitted'));
            exit;
        }
    }
}
