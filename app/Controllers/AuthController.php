<?php

class AuthController extends Controller {
    public function index() {
        if(isset($_SESSION['user_id'])) {
            $redirect = ($_SESSION['user_role'] == 'admin') ? 'admin' : 'student';
            header('Location: ' . base_url($redirect));
            exit;
        }
        $this->view('auth/login');
    }

    public function login_process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User_model');
            $user = $userModel->getUserByEmail($_POST['username']);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['name'];

                $redirect = ($user['role'] == 'admin') ? 'admin' : 'student';
                header('Location: ' . base_url($redirect));
                exit;
            } else {
                header('Location: ' . base_url('auth?error=wrong'));
                exit;
            }
        }
    }

    public function register() {
        if(isset($_SESSION['user_id'])) {
            $redirect = ($_SESSION['user_role'] == 'admin') ? 'admin' : 'student';
            header('Location: ' . base_url($redirect));
            exit;
        }
        
        $kuota = $this->model('Settings_model')->getSetting('kuota_pendaftaran') ?? 100;
        $db = new Database();
        $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status != 'belum_mendaftar'");
        $total = $db->single()['total'];
        
        if ($total >= $kuota) {
            $this->view('auth/login', ['error_msg' => 'Maaf, kuota pendaftaran sudah penuh.']);
            return;
        }

        $this->view('auth/register');
    }

    public function register_process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $kuota = $this->model('Settings_model')->getSetting('kuota_pendaftaran') ?? 100;
            $db = new Database();
            $db->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status != 'belum_mendaftar'");
            $total = $db->single()['total'];
            
            if ($total >= $kuota) {
                header('Location: ' . base_url('auth?error=full'));
                exit;
            }

            if ($_POST['password'] !== $_POST['password_confirm']) {
                header('Location: ' . base_url('auth/register?error=password'));
                exit;
            }

            $userModel = $this->model('User_model');

            if ($userModel->getUserByEmail($_POST['email'])) {
                header('Location: ' . base_url('auth/register?error=exists'));
                exit;
            }

            $uid = $userModel->registerUser([
                'name'     => $_POST['name'],
                'email'    => $_POST['email'],
                'password' => $_POST['password'],
            ]);

            if ($uid) {
                // Auto-init all tables for new user
                foreach (['DataPribadi_model','DataAyah_model','DataIbu_model','DataWali_model','DataKontak_model','DataPeriodik_model','Dokumen_model','Pendaftaran_model'] as $m) {
                    $this->model($m)->init($uid);
                }
                header('Location: ' . base_url('auth?success=registered'));
            } else {
                header('Location: ' . base_url('auth/register?error=failed'));
            }
            exit;
        }
    }

    public function forgot_password() {
        if(isset($_SESSION['user_id'])) {
            $redirect = ($_SESSION['user_role'] == 'admin') ? 'admin' : 'student';
            header('Location: ' . base_url($redirect));
            exit;
        }
        $this->view('auth/forgot_password');
    }

    public function forgot_password_process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $userModel = $this->model('User_model');
            $user = $userModel->getUserByEmail($email);

            if ($user) {
                // Generate 6-digit OTP
                $otp = sprintf("%06d", mt_rand(1, 999999));
                $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                
                $userModel->saveResetToken($email, $otp, $expires);
                
                // --- PENGIRIMAN EMAIL SUNGGUHAN DENGAN PHPMAILER ---
                require_once '../vendor/autoload.php';
                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

                try {
                    // Konfigurasi Server SMTP
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com'; 
                    $mail->SMTPAuth   = true;
                    // TODO: GANTI APP PASSWORD DI BAWAH INI DENGAN 16 DIGIT SANDI APLIKASI
                    $mail->Username   = 'andikadaffafathirabbani@gmail.com'; 
                    $mail->Password   = 'APP_PASSWORD_GMAIL_ANDA'; 
                    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    // Pengirim dan Penerima
                    $mail->setFrom('andikadaffafathirabbani@gmail.com', 'Admin PPDB MIS Nurul Ikhlas');
                    $mail->addAddress($email);

                    // Konten Email
                    $mail->isHTML(true);
                    $mail->Subject = 'Kode Verifikasi Lupa Password (OTP)';
                    $mail->Body    = "
                        <div style='font-family: Arial, sans-serif; padding: 20px; text-align: center;'>
                            <h2>Atur Ulang Password Anda</h2>
                            <p>Seseorang telah meminta untuk mengatur ulang password akun Anda.</p>
                            <p>Berikut adalah kode verifikasi OTP Anda:</p>
                            <h1 style='background-color: #f3f4f6; padding: 15px; letter-spacing: 5px; color: #10b981; display: inline-block;'>$otp</h1>
                            <p>Kode ini hanya berlaku selama 15 menit.</p>
                            <p>Jika Anda tidak merasa meminta kode ini, abaikan saja email ini.</p>
                        </div>
                    ";

                    $mail->send();
                    
                    // Simpan email ke session untuk verifikasi OTP
                    $_SESSION['reset_email'] = $email;
                    header('Location: ' . base_url('auth/verify_otp'));
                    exit;

                } catch (Exception $e) {
                    header('Location: ' . base_url('auth/forgot_password?error=email_failed'));
                    exit;
                }
                // ----------------------------------------------------
            } else {
                header('Location: ' . base_url('auth/forgot_password?error=email_not_found'));
                exit;
            }
        }
    }

    public function verify_otp() {
        if (!isset($_SESSION['reset_email'])) {
            header('Location: ' . base_url('auth/forgot_password'));
            exit;
        }
        $this->view('auth/verify_otp');
    }

    public function verify_otp_process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_SESSION['reset_email'] ?? '';
            $otp = trim($_POST['otp'] ?? '');
            
            $userModel = $this->model('User_model');
            $validToken = $userModel->verifyResetToken($email, $otp);

            if ($validToken) {
                $_SESSION['otp_verified'] = true;
                header('Location: ' . base_url('auth/reset_password'));
                exit;
            } else {
                header('Location: ' . base_url('auth/verify_otp?error=invalid_otp'));
                exit;
            }
        }
    }

    public function reset_password() {
        if (!isset($_SESSION['reset_email']) || !isset($_SESSION['otp_verified'])) {
            header('Location: ' . base_url('auth/forgot_password'));
            exit;
        }
        $this->view('auth/reset_password');
    }

    public function reset_password_process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['reset_email']) || !isset($_SESSION['otp_verified'])) {
                header('Location: ' . base_url('auth/forgot_password'));
                exit;
            }

            $email = $_SESSION['reset_email'];
            $newPassword = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword) {
                header('Location: ' . base_url('auth/reset_password?error=password_mismatch'));
                exit;
            }

            $userModel = $this->model('User_model');
            $userModel->updatePassword($email, $newPassword);
            $userModel->clearResetToken($email);
            
            // Hapus session reset
            unset($_SESSION['reset_email']);
            unset($_SESSION['otp_verified']);
            unset($_SESSION['simulated_otp']);

            header('Location: ' . base_url('auth?success=password_reset'));
            exit;
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . base_url());
        exit;
    }
}
