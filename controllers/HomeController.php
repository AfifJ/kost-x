<?php
class HomeController {
    public function dashboard() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
    }

    public function index() {
        // Logika untuk halaman utama (publik)
        $data = [
            'title' => 'Selamat Datang',
            'description' => 'Halaman utama website'
        ];

        include '../views/index.php';
    }

}