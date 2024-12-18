<?php
session_start();

require_once '../controllers/AuthController.php';
require_once '../controllers/HomeController.php';

$authController = new AuthController();
$homeController = new HomeController();

// Fungsi untuk memeriksa status login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Dapatkan path dari URL
$request = $_SERVER['REQUEST_URI'];

// Hapus query string jika ada
$request = strtok($request, '?');

// Daftar halaman yang bisa diakses tanpa login
$publicRoutes = ['/login', '/register', '/forgot-password', '/'];

// Daftar halaman yang bisa diakses oleh semua orang (termasuk 404)
$alwaysAccessibleRoutes = ['/404'];

// Routing manual
switch ($request) {
    case '/':
    case '':
        if (isLoggedIn()) {
            header("Location: /dashboard");
        } else {
            header("Location: /login");
        }
        exit();
    
    case '/login':
    case '/register':
    case '/forgot-password':
        // Jika sudah login, redirect ke dashboard
        if (isLoggedIn()) {
            header("Location: /dashboard");
            exit();
        }

        // Proses login/register
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $request === '/login' ? $authController->login() : 
                      ($request === '/register' ? $authController->register() : 
                       $authController->forgotPassword());
        } else {
            $errors = [];
        }

        // Tentukan view berdasarkan rute
        $view = substr($request, 1) . '.php';
        include "../views/$view";
        break;
    
    case '/dashboard':
    case '/profile':
    case '/settings':
        // Cek apakah sudah login
        if (!isLoggedIn()) {
            header("Location: /login");
            exit();
        }

        // Proses halaman yang membutuhkan login
        switch ($request) {
            case '/dashboard':
                $homeController->dashboard();
                include '../views/dashboard.php';
                break;
            case '/profile':
                $homeController->profile();
                include '../views/profile.php';
                break;
            case '/settings':
                $homeController->settings();
                include '../views/settings.php';
                break;
        }
        break;
    
    case '/logout':
        $authController->logout();
        break;
    
    case '/404':
        http_response_code(404);
        include '../views/404.php';
        break;
    
    default:
        // Cek apakah halaman selain rute yang ditentukan bisa diakses
        if (!isLoggedIn() && !in_array($request, $publicRoutes) && !in_array($request, $alwaysAccessibleRoutes)) {
            header("Location: /login");
            exit();
        }

        // Jika tidak ada rute yang cocok, tampilkan 404
        http_response_code(404);
        include '../views/404.php';
        break;
}