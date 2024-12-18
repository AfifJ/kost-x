<?php
session_start();

require_once '../controllers/AuthController.php';
require_once '../controllers/HomeController.php';
require_once '../controllers/DashboardController.php';
require_once '../controllers/KostController.php';
require_once '../controllers/BookingController.php';
require_once '../controllers/ComplaintController.php';
require_once '../controllers/PaymentController.php';

$kostController = new KostController();
$authController = new AuthController();
$homeController = new HomeController();
$dashboardController = new DashboardController();
$bookingController = new BookingController();
$complaintController = new ComplaintController();
$paymentController = new PaymentController();

// Fungsi untuk memeriksa status login
function isLoggedIn()
{
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
        // Halaman utama bisa diakses oleh semua
        $homeController->index();
        // include '../views/index.php';
        break;

    case '/dashboard':
        // Halaman dashboard hanya bisa diakses setelah login
        if (!isLoggedIn()) {
            header("Location: /login");
            exit();
        }

        $dashboardController->index();
        break;

    case '/login':
    case '/register':
    case '/forgot-password':
        // Jika sudah login, redirect ke beranda
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

    case '/profile':
    case '/settings':
        // Cek apakah sudah login
        if (!isLoggedIn()) {
            header("Location: /login");
            exit();
        }

        // Proses halaman yang membutuhkan login
        switch ($request) {
            case '/profile':
                $dashboardController->profile();
                include '../views/profile.php';
                break;
            case '/settings':
                $dashboardController->settings();
                include '../views/settings.php';
                break;
        }
        break;

    case '/logout':
        $authController->logout();
        break;

    case '/kost':
        if (!isLoggedIn()) {
            header("Location: /login");
            exit();
        }
        $kostController->index();
        // Route to different pages based on user type
        // if ($_SESSION['user_type'] === 'admin') {
        //     $kostController->adminIndex();
        // } else {
        //     header("Location: /cari-kost");
        // }
        break;

    case '/kost/create':
        if (!isLoggedIn() || $_SESSION['user_type'] !== 'admin') {
            header("Location: /login");
            exit();
        }
        $kostController->create();
        break;

    case '/kost/manage':
        if (!isLoggedIn()) {
            header("Location: /login");
            exit();
        }
        $kostController->index();
        break;

    case '/kost/edit':
        if (!isLoggedIn()) {
            header("Location: /login");
            exit();
        }
        
        if (!$kostController->isOwner($_GET['id'])) {
            header("Location: /404");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kostController->update($_GET['id']);
            break;
        }
        $kostController->updateView($_GET['id']);
        break;

    case '/kost/hapus':
        if (!isLoggedIn() || !$kostController->isOwner($_GET['id'])) {
            header("Location: /404");
            exit();
        }
        $kostController->delete($_GET['id']);
        break;

    case '/kost/detail':
        $kost = $kostController->getById($_GET['id']);
        if ($kostController->isOwner($_GET['id'])) {
            
            $kost['complaints'] = $complaintController->getKostComplaints($_GET['id']);
            include '../views/admin-kost/detail.php';
        } else {
            include '../views/pencari/detail.php';
        }
        break;

    case '/cari-kost/detail':
        $kost = $kostController->getById($_GET['id']);
            include '../views/pencari/detail.php';
        break;

    case '/kost/book':
        if (!isLoggedIn()) {
            header('Location: /login');
            exit();
        }
        $bookingController->bookKost();
        break;

    case '/kost/checkout':
        if (!isLoggedIn()) {
            header('Location: /login');
            exit();
        }
        $bookingController->checkoutKost();
        break;

    case '/cari-kost':
        $alamat = $_GET['alamat'] ?? '';
        $results = $kostController->search($alamat);
        include '../views/pencari/cari-kost.php';
        break;

    case '/404':
        http_response_code(404);
        include '../views/404.php';
        break;

    case '/complaint/submit':
        if (!isLoggedIn()) {
            header('Location: /login');
            exit();
        }
        $complaintController->submitComplaint();
        break;

    case '/complaint/update-status':
        if (!isLoggedIn()) {
            header('Location: /login');
            exit();
        }
        $complaintController->updateComplaintStatus();
        break;

    case '/complaint/delete':
        if (!isLoggedIn()) {
            header('Location: /login');
            exit();
        }
        $complaintController->deleteComplaint();
        break;

    case '/payment/process':
        if (!isLoggedIn()) {
            header('Location: /login');
            exit();
        }
        $paymentController->processPayment();
        break;

    case '/payment/success':
        if (!isLoggedIn()) {
            header('Location: /login');
            exit();
        }
        $paymentController->paymentSuccess();
        break;

    case '/payment/failure':
        if (!isLoggedIn()) {
            header('Location: /login');
            exit();
        }
        $paymentController->paymentFailure();
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