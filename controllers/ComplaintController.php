<?php
require_once '../models/Complaint.php';
require_once '../config/Database.php';

class ComplaintController {
    private $complaintModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->complaintModel = new Complaint($this->db);
    }

    public function submitComplaint() {
        if (!isset($_SESSION['user_id']) || empty($_POST['complaint_text'])) {
            header('Location: /dashboard?error=invalid_complaint');
            exit;
        }

        // Validasi booking aktif
        $activeBooking = $this->validateActiveBooking();
        if (!$activeBooking) {
            header('Location: /dashboard?error=no_active_booking');
            exit;
        }

        $data = [
            'booking_id' => $_POST['booking_id'],
            'user_id' => $_SESSION['user_id'],
            'kost_id' => $_POST['kost_id'],
            'complaint_text' => trim($_POST['complaint_text'])
        ];

        $success = $this->complaintModel->create($data);
        
        if ($success) {
            // Optional: Kirim notifikasi ke pemilik kost
            $this->sendComplaintNotification($data);
            header('Location: /dashboard?success=complaint_submitted');
        } else {
            header('Location: /dashboard?error=complaint_failed');
        }
        exit;
    }

    public function getUserComplaints($user_id) {
        if (!isset($user_id)) {
            return [];
        }
        return $this->complaintModel->getUserComplaints($user_id);
    }

    public function updateComplaintStatus() {
        if (!isset($_POST['complaint_id']) || !isset($_POST['status'])) {
            header('Location: /dashboard?error=invalid_request');
            exit;
        }

        $complaint_id = $_POST['complaint_id'];
        $status = $_POST['status'];
        $kost_id = $_GET['id'];

        if ($this->complaintModel->updateStatus($complaint_id, $status)) {
            header('Location: /kost?success=status_updated');
            // header('Location: /kost/detail?id=' . $kost_id . '&success=status_updated');
        } else {
            header('Location: /kost?error=status_update_failed');
            // header('Location: /kost/detail?id=' . $kost_id . '&error=status_update_failed');
        }
        exit;
    }

    public function deleteComplaint() {
        if (!isset($_POST['complaint_id'])) {
            header('Location: /dashboard?error=invalid_request');
            exit;
        }

        $complaint_id = $_POST['complaint_id'];

        if ($this->complaintModel->delete($complaint_id)) {
            header('Location: /kost?success=complaint_deleted');
        } else {
            header('Location: /kost?error=complaint_delete_failed');
        }
        exit;
    }

    public function getKostComplaints($kost_id) {
        return $this->complaintModel->getKostComplaints($kost_id);
    }

    private function validateActiveBooking() {
        global $bookingController;
        return $bookingController->getUserActiveBooking($_SESSION['user_id']);
    }

    private function isAuthorized() {
        // Implementasi pengecekan authorization
        return isset($_SESSION['user_id']) && 
               ($_SESSION['user_type'] === 'admin' || $this->isKostOwner());
    }

    private function sendComplaintNotification($data) {
        // TODO: Implementasi sistem notifikasi
        // Bisa menggunakan email, SMS, atau notifikasi in-app
        // Contoh basic logging:
        error_log("New complaint submitted for kost ID: " . $data['kost_id']);
    }

    private function isKostOwner() {
        // TODO: Implementasi pengecekan kepemilikan kost
        global $kostController;
        return isset($_POST['kost_id']) && $kostController->isOwner($_POST['kost_id']);
    }
}
