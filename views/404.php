<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title'] ?? 'Temukan Kost Nyaman Anda') ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://unsplash.it/1920/1080?random') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .features-section {
            padding: 50px 0;
            background-color: #f8f9fa;
        }
        .feature-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include "navbar.php"?>
    <div class="hero-section">
        <h1>404 - Halaman Tidak Ditemukan</h1>
        <p>Maaf, halaman yang Anda cari tidak tersedia.</p>
   
    </div>
    <div class="features-section text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-icon">
                        <i class="bi bi-house-door"></i>
                    </div>
                    <h3>Nyaman</h3>
                    <p>Temukan kost yang nyaman dan aman untuk Anda.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h3>Strategis</h3>
                    <p>Lokasi kost yang strategis dekat dengan kampus dan fasilitas umum.</p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <h3>Terjangkau</h3>
                    <p>Harga kost yang terjangkau sesuai dengan kantong mahasiswa.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>