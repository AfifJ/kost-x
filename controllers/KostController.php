<?php
require_once '../models/Kost.php';
require_once '../config/Database.php';

class KostController
{
    private $model;
    private $db;

    public function __construct()
    {

        $database = new Database();
        $this->db = $database->getConnection();
        $this->model = new Kost($this->db);
    }

    // Tampilkan semua data
    public function index()
    {
        if (isset($_SESSION['user_id'])) {
            $kosts = $this->model->getAllByOwnerId($_SESSION['user_id']);
        } else {
            $kosts = [];
        }
        require '../views/admin-kost/index.php';
    }
    // Simpan data baru
    public function create($data = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_kost' => $_POST['nama_kost'],
                'alamat' => $_POST['alamat'],
                'latitude' => $_POST['latitude'],
                'longitude' => $_POST['longitude'],
                'deskripsi_umum' => $_POST['deskripsi_umum'],
                'tipe_kost' => $_POST['tipe_kost'],
                'jam_bertamu' => $_POST['jam_bertamu'],
                'aturan_kost' => $_POST['aturan_kost'],
                'kontak_pemilik' => $_POST['kontak_pemilik'],
                'email_pemilik' => $_POST['email_pemilik'],
                'kamar_tersedia' => $_POST['kamar_tersedia'],
                'owner_id' => $_SESSION['user_id'] // Add owner_id
            ];
            
            $this->model->create($data);
            header('Location: /kost');
        } else {
            include "../views/admin-kost/create.php";
        }
    }

    // Update data
    public function update($id)
    {
        $data = [
            'nama_kost' => $_POST['nama_kost'],
            'alamat' => $_POST['alamat'],
            'latitude' => $_POST['latitude'],
            'longitude' => $_POST['longitude'],
            'deskripsi_umum' => $_POST['deskripsi_umum'],
            'tipe_kost' => $_POST['tipe_kost'],
            'jam_bertamu' => $_POST['jam_bertamu'],
            'aturan_kost' => $_POST['aturan_kost'],
            'kontak_pemilik' => $_POST['kontak_pemilik'],
            'email_pemilik' => $_POST['email_pemilik'],
            'kamar_tersedia' => $_POST['kamar_tersedia']
        ];
        $this->model->update($id, $data);
        header('Location: /kost');
    }
    public function updateView($id)
    {
        $kost = $this->model->getById($id);
        include "../views/admin-kost/edit.php";
    }

    // Hapus data
    public function delete($id)
    {
        $this->model->delete($id);
        header("Location: /kost");
    }

    // Cari data kost
    public function search($alamat)
    {
        return $this->model->search($alamat);
    }

    // Ambil data kost berdasarkan ID
    public function getById($id)
    {
        global $bookingController;
        $kost = $this->model->getById($id);
        
        // Get active booking if user is logged in
        if (isset($_SESSION['user_id'])) {
            $activeBooking = $bookingController->getUserActiveBooking($_SESSION['user_id']);
        }

        // If admin is viewing, fetch complaints
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
            global $complaintController;
            $complaints = $complaintController->getKostComplaints($id);
            $kost['complaints'] = $complaints;
        }
        
        return $kost;
    }

    public function isOwner($kost_id)
    {
        $kost = $this->model->getById($kost_id);
        return isset($_SESSION['user_id']) && $kost && $kost['owner_id'] == $_SESSION['user_id'];
    }

    private function uploadFoto()
    {

        if (!isset($_FILES['foto_kost']) || $_FILES['foto_kost']['error'] == UPLOAD_ERR_NO_FILE) {

            return null;

        }


        $uploadDir = '../public/uploads/kost/';

        // Buat direktori jika belum ada

        if (!is_dir($uploadDir)) {

            mkdir($uploadDir, 0777, true);

        }


        $fileName = uniqid() . '_' . basename($_FILES['foto_kost']['name']);

        $uploadPath = $uploadDir . $fileName;


        // Validasi tipe file

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        $fileType = $_FILES['foto_kost']['type'];



        if (!in_array($fileType, $allowedTypes)) {

            return false;

        }


        // Validasi ukuran file (max 5MB)

        if ($_FILES['foto_kost']['size'] > 5 * 1024 * 1024) {

            return false;

        }


        // Upload file

        if (move_uploaded_file($_FILES['foto_kost']['tmp_name'], $uploadPath)) {

            return $fileName;

        }


        return false;

    }

}
