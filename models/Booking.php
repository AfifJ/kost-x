<?php

class Booking {
    private $table = "bookings";
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserBookingStatus($user_id) {
        $query = "SELECT k.nama_kost, b.* FROM " . $this->table . " b 
                  JOIN kost k ON b.kost_id = k.id 
                  WHERE b.user_id = :user_id AND b.status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserActiveBooking($user_id) {
        $query = "SELECT b.*, k.nama_kost FROM " . $this->table . " b 
                  JOIN kost k ON b.kost_id = k.id 
                  WHERE b.user_id = :user_id AND b.status = 'active' 
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createBooking($user_id, $kost_id) {
        // Check if user already has an active booking
        if ($this->getUserActiveBooking($user_id)) {
            return false;
        }

        $this->conn->beginTransaction();
        try {
            // Create new booking with active status
            $query = "INSERT INTO " . $this->table . " 
                     (user_id, kost_id, booking_date, status) 
                     VALUES (:user_id, :kost_id, NOW(), 'active')";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([
                'user_id' => $user_id,
                'kost_id' => $kost_id
            ]);

            if (!$result) {
                throw new Exception("Failed to create booking");
            }

            // Update room availability
            $query = "UPDATE kost SET kamar_tersedia = kamar_tersedia - 1 
                     WHERE id = :kost_id AND kamar_tersedia > 0";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute(['kost_id' => $kost_id]);

            if (!$result) {
                throw new Exception("Failed to update room availability");
            }

            $this->conn->commit();
            return true;
        } catch(Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function updateBookingStatus($booking_id, $status) {
        $query = "UPDATE " . $this->table . " SET 
                  status = :status,
                  checkout_date = CASE 
                    WHEN :status = 'completed' THEN NOW() 
                    ELSE checkout_date 
                  END
                  WHERE id = :booking_id";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'status' => $status,
            'booking_id' => $booking_id
        ]);
    }

    public function getUserActiveBookingWithKostDetails($user_id) {
        $query = "SELECT b.*, k.nama_kost, k.alamat, k.tipe_kost 
                 FROM bookings b 
                 JOIN kost k ON b.kost_id = k.id 
                 WHERE b.user_id = :user_id 
                 AND b.status = 'active' 
                 LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
