<?php
require_once 'config/database.php';

class Kamar {
    private $conn;
    private $table = 'kamar';

    public $id;
    public $nomor;
    public $fasilitas;
    public $harga;
    public $status;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Read All Kamar
    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->conn->query($query);
        return $result;
    }

    // Create Kamar
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (nomor, fasilitas, harga, status) 
                  VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", 
            $this->nomor, 
            $this->fasilitas, 
            $this->harga, 
            $this->status
        );

        return $stmt->execute();
    }

    // Read Single Kamar
    public function readOne() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Update Kamar
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nomor = ?, fasilitas = ?, harga = ?, status = ? 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", 
            $this->nomor, 
            $this->fasilitas, 
            $this->harga, 
            $this->status, 
            $this->id
        );

        return $stmt->execute();
    }

    // Delete Kamar
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
?>