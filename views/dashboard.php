<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
    <?php if(isset($_GET['success']) && $_GET['success'] === 'checkout_complete'): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <strong>Berhasil!</strong> Anda telah keluar dari kost.
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <?php 
                $error_message = "Terjadi kesalahan.";
                if($_GET['error'] === 'no_active_booking') {
                    $error_message = "Anda tidak memiliki kost aktif.";
                } elseif($_GET['error'] === 'checkout_failed') {
                    $error_message = "Gagal melakukan checkout. Silakan coba lagi.";
                }
                echo $error_message;
            ?>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <h1 class="my-4">Selamat Datang, <?= htmlspecialchars($data['username']) ?></h1>


    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Status Kost Anda</h5>
        </div>
        <div class="card-body">
            <?php if(isset($data['activeBooking']) && $data['activeBooking']): ?>
                <div class="alert alert-info">
                    <h6>Kost Aktif:</h6>
                    <p><i class="fas fa-home"></i> <?php echo htmlspecialchars($data['activeBooking']['nama_kost']); ?></p>
                    <p><i class="fas fa-calendar-check"></i> Mulai: <?php echo date('d F Y', strtotime($data['activeBooking']['booking_date'])); ?></p>
                </div>
                
                <form action="/kost/checkout" method="POST" onsubmit="return confirm('Anda yakin ingin keluar dari kost ini?');">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-sign-out-alt"></i> Keluar dari Kost
                    </button>
                </form>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i> Anda belum memiliki kost aktif. 
                    <a href="/cari-kost" class="alert-link">Cari kost sekarang!</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add this after the active booking card -->
    <?php if(isset($data['activeBooking']) && $data['activeBooking']): ?>
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ajukan Keluhan</h5>
            </div>
            <div class="card-body">
                <form action="/complaint/submit" method="POST">
                    <input type="hidden" name="booking_id" value="<?php echo $data['activeBooking']['id']; ?>">
                    <input type="hidden" name="kost_id" value="<?php echo $data['activeBooking']['kost_id']; ?>">
                    
                    <div class="form-group">
                        <label for="complaint_text">Keluhan Anda:</label>
                        <textarea class="form-control" id="complaint_text" name="complaint_text" 
                                  rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-exclamation-circle"></i> Kirim Keluhan
                    </button>
                </form>
            </div>
        </div>

        <?php if(isset($data['complaints']) && !empty($data['complaints'])): ?>
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Riwayat Keluhan</h5>
                </div>
                <div class="card-body">
                    <?php foreach($data['complaints'] as $complaint): ?>
                        <div class="alert alert-secondary">
                            <p><strong>Tanggal:</strong> <?php echo date('d F Y', strtotime($complaint['created_at'])); ?></p>
                            <p><strong>Status:</strong> 
                                <span class="badge badge-<?php echo $complaint['status'] === 'resolved' ? 'success' : 
                                    ($complaint['status'] === 'in_progress' ? 'warning' : 'danger'); ?>">
                                    <?php echo ucfirst($complaint['status']); ?>
                                </span>
                            </p>
                            <p><?php echo htmlspecialchars($complaint['complaint_text']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="stats mb-4">
        <!-- Tampilkan statistik -->
    </div>
    
    <nav class="nav flex-column">
        <a class="nav-link" href="/">Home</a>
        <a class="nav-link" href="/kost">Manage Kost</a>
        <a class="nav-link" href="/profile">Profil</a>
        <a class="nav-link" href="/settings">Pengaturan</a>
        <a class="nav-link" href="/logout">Logout</a>
        <a class="nav-link" href="/cari-kost">Cari Kost</a>
    </nav>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>