<?php
class DashboardController {
    public function index() {
        global $bookingController;

        // Pastikan sudah login
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        
        // Logika untuk dashboard
        $data = [
            'username' => $_SESSION['username'],
            'user_type' => $_SESSION['user_type'],
            'stats' => $this->getUserStats()
        ];

        // Get active booking information
        if (isset($_SESSION['user_id'])) {
            $data['activeBooking'] = $bookingController->getUserActiveBooking($_SESSION['user_id']);
        }

        // Get user's complaints if they have an active booking
        if (isset($data['activeBooking'])) {
            global $complaintController;
            $data['complaints'] = $complaintController->getUserComplaints($_SESSION['user_id']);
        }

        include '../views/dashboard.php';
    }

    public function profile() {
        // Logika halaman profil
        $data = [
            'user' => $this->getUserProfile()
        ];
    }

    public function settings() {
        // Logika halaman pengaturan
        $data = [
            'settings' => $this->getUserSettings()
        ];
    }

    private function getUserStats() {
        // Ambil statistik user
    }

    private function getUserProfile() {
        // Ambil data profil user
    }

    private function getUserSettings() {
        // Ambil pengaturan user
    }
}