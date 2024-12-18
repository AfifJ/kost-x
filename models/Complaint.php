<?php
class Complaint {
    private $table = "complaints";
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                 (booking_id, user_id, kost_id, complaint_text) 
                 VALUES (:booking_id, :user_id, :kost_id, :complaint_text)";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    public function getUserComplaints($user_id) {
        $query = "SELECT c.*, k.nama_kost 
                 FROM " . $this->table . " c
                 JOIN kost k ON c.kost_id = k.id
                 WHERE c.user_id = :user_id 
                 ORDER BY c.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKostComplaints($kost_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE kost_id = :kost_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['kost_id' => $kost_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($complaint_id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :complaint_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['status' => $status, 'complaint_id' => $complaint_id]);
    }

    public function delete($complaint_id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :complaint_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['complaint_id' => $complaint_id]);
    }
}
