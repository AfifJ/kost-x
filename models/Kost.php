<?php

class Kost
{
    private $table = "kost";
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Ambil semua data
    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil semua data berdasarkan owner_id
    public function getAllByOwnerId($owner_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE owner_id = :owner_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['owner_id' => $owner_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah data baru
    public function create($data)
    {

        $query = "INSERT INTO " . $this->table . " (nama_kost, alamat, latitude, longitude, deskripsi_umum, tipe_kost, jam_bertamu, aturan_kost, kontak_pemilik, email_pemilik, kamar_tersedia) 
                  VALUES (:nama_kost, :alamat, :latitude, :longitude, :deskripsi_umum, :tipe_kost, :jam_bertamu, :aturan_kost, :kontak_pemilik, :email_pemilik, :kamar_tersedia)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    // Ambil data berdasarkan ID
    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update data
    public function update($id, $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET nama_kost=:nama_kost, alamat=:alamat, latitude=:latitude, longitude=:longitude, deskripsi_umum=:deskripsi_umum, tipe_kost=:tipe_kost, jam_bertamu=:jam_bertamu, aturan_kost=:aturan_kost, kontak_pemilik=:kontak_pemilik, email_pemilik=:email_pemilik, kamar_tersedia=:kamar_tersedia 
                  WHERE id=:id";
        $data['id'] = $id;
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }

    // Hapus data
    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    // Cari data berdasarkan alamat, latitude, dan longitude
    public function search($alamat)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE alamat LIKE :alamat";
        $params = ['alamat' => '%' . $alamat . '%'];

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil data kost berdasarkan pemilik
    public function getKostByOwner($owner_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE owner_id = :owner_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['owner_id' => $owner_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
