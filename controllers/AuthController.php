<?php
require_once '../config/Database.php';
require_once '../models/UserModel.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        // Buat koneksi database
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Inisiasi model user
        $this->user = new User($this->db);
    }

    public function register() {
        // Ambil data dari form
        $this->user->username = $_POST['username'];
        $this->user->email = $_POST['email'];
        $this->user->password = $_POST['password'];

        // Cek apakah email sudah ada
        if ($this->user->emailExists()) {
            return ["Email sudah terdaftar"];
        }

        // Proses registrasi
        if ($this->user->create()) {
            header("Location: /login");
        } else {
            return ["Registrasi gagal"];
        }
    }

    public function login() {
        // Ambil data dari form
        $this->user->email = $_POST['email'];
        $this->user->password = $_POST['password'];

        // Proses autentikasi
        if ($this->user->authenticate()) {
            // Set session
            $_SESSION['user_id'] = $this->user->id;
            $_SESSION['username'] = $this->user->username;
            $_SESSION['user_type'] = $this->user->user_type;

            header('Location: /dashboard');
            return ["Login berhasil"];
        } else {
            return ["Email atau password salah"];
        }
    }

    public function logout() {
        // Mulai sesi jika belum dimulai
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Hapus semua data sesi
        $_SESSION = [];
        
        // Hancurkan sesi
        session_destroy();
        
        // Hapus cookie sesi
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Redirect ke halaman login
        header("Location: /login");
        exit();
    }
}