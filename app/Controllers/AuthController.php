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

    public function reset_password_process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $newPassword = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword) {
                header('Location: ' . base_url('auth/forgot_password?error=password_mismatch'));
                exit;
            }

            $userModel = $this->model('User_model');
            $user = $userModel->getUserByEmail($email);

            if (!$user) {
                // To prevent email enumeration, we might just say success or show error.
                // Let's show error for simplicity in this system.
                header('Location: ' . base_url('auth/forgot_password?error=email_not_found'));
                exit;
            }

            $userModel->updatePassword($email, $newPassword);
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
