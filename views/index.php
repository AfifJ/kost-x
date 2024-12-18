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
    <?php 
    include "navbar.php" 
    
    ?>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4 mb-4"><?= htmlspecialchars($data['title'] ?? 'Temukan Kost Nyaman Anda') ?></h1>
            <p class="lead mb-5"><?= htmlspecialchars($data['description'] ?? 'Solusi tepat untuk pencarian kost yang aman, nyaman, dan terjangkau di seluruh Indonesia') ?></p>
            
            <!-- <?php if (!isLoggedIn()): ?>
                <div class="d-flex justify-content-center gap-3">
                    <a href="/login" class="btn btn-primary btn-lg">Login</a>
                    <a href="/register" class="btn btn-outline-light btn-lg">Daftar Sekarang</a>
                </div>
            <?php else: ?>
                <a href="/dashboard" class="btn btn-primary btn-lg">Masuk Dashboard</a>
            <?php endif; ?> -->
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">🏠</div>
                    <h3>Ribuan Pilihan Kost</h3>
                    <p>Temukan kost sesuai kebutuhan Anda dari berbagai lokasi di Indonesia.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">🔍</div>
                    <h3>Pencarian Mudah</h3>
                    <p>Filter berdasarkan lokasi, harga, fasilitas, dan kriteria lainnya.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">💬</div>
                    <h3>Ulasan Transparan</h3>
                    <p>Baca pengalaman penghuni sebelumnya untuk keputusan tepat.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial Section -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 mx-auto text-center">
                <blockquote class="blockquote">
                    <p>"Aplikasi ini membantu saya menemukan kost impian dengan mudah dan cepat!"</p>
                    <footer class="blockquote-footer">— Budi, Mahasiswa</footer>
                </blockquote>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>