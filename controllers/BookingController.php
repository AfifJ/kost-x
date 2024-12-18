<?php
require_once '../models/Booking.php';
require_once '../config/Database.php';

class BookingController {
    private $bookingModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->bookingModel = new Booking($this->db);
    }

    public function getUserActiveBooking($user_id) {
        return $this->bookingModel->getUserActiveBooking($user_id);
    }

    public function bookKost() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Check if user already has active booking
        $activeBooking = $this->getUserActiveBooking($_SESSION['user_id']);
        if ($activeBooking) {
            header('Location: /cari-kost/detail?id=' . $_POST['kost_id'] . '&error=already_booked');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kost_id'])) {
            // Langsung kirim user_id dan kost_id ke createBooking
            $success = $this->bookingModel->createBooking($_SESSION['user_id'], $_POST['kost_id']);
            
            header('Location: /cari-kost/detail?id=' . $_POST['kost_id'] . 
                  ($success ? '&success=1' : '&error=1'));
            exit;
        }
    }

    public function checkoutKost() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $activeBooking = $this->getUserActiveBooking($_SESSION['user_id']);
        if (!$activeBooking) {
            header('Location: /dashboard?error=no_active_booking');
            exit;
        }

        $this->db->beginTransaction();
        try {
            // Update booking status
            $success = $this->bookingModel->updateBookingStatus($activeBooking['id'], 'completed');
            
            if ($success) {
                // Increment kamar_tersedia
                $this->incrementKamarTersedia($activeBooking['kost_id']);
                $this->db->commit();
                header('Location: /dashboard?success=checkout_complete');
            } else {
                throw new Exception("Failed to update booking status");
            }
        } catch(Exception $e) {
            $this->db->rollBack();
            header('Location: /dashboard?error=checkout_failed');
        }
        exit;
    }

    private function updateKamarTersedia($kost_id) {
        $query = "UPDATE kost SET kamar_tersedia = kamar_tersedia - 1 
                  WHERE id = :kost_id AND kamar_tersedia > 0";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['kost_id' => $kost_id]);
    }

    private function incrementKamarTersedia($kost_id) {
        $query = "UPDATE kost SET kamar_tersedia = kamar_tersedia + 1 WHERE id = :kost_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['kost_id' => $kost_id]);
    }
}
