<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 800px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: none;
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .welcome-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .nav-custom {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .nav-custom .nav-link {
            color: #495057;
            transition: all 0.3s ease;
        }
        .nav-custom .nav-link:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }
        .complaint-status-badge {
            font-size: 0.9em;
            padding: 0.3em 0.6em;
        }
    </style>
</head>
<body>
    <?php include __DIR__."/navbar.php" ?>

    <div class="container">
        <!-- Search Button -->
        <div class="d-flex justify-content-end mt-3">
            <a href="/cari-kost" class="btn btn-primary">
                <i class="fas fa-search mr-2"></i> Cari Kost
            </a>
        </div>

        <!-- Success Alert -->
        <?php if(isset($_GET['success']) && $_GET['success'] === 'checkout_complete'): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <strong>Berhasil!</strong> Anda telah keluar dari kost.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Error Alert -->
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
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Welcome Header -->
        <div>
            <h1 class="mb-0">Selamat Datang, <?= htmlspecialchars($data['username']) ?></h1>
        </div>

        <!-- Kost Status Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Status Kost Anda</h5>
            </div>
            <div class="card-body">
                <?php if(isset($data['activeBooking']) && $data['activeBooking']): ?>
                    <div class="alert alert-info d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-home fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Kost Aktif: <?php echo htmlspecialchars($data['activeBooking']['nama_kost']); ?></h6>
                            <p class="mb-0">
                                <i class="fas fa-calendar-check"></i> 
                                Mulai: <?php echo date('d F Y', strtotime($data['activeBooking']['booking_date'])); ?>
                            </p>
                        </div>
                    </div>
                    
                    <form action="/kost/checkout" method="POST" onsubmit="return confirm('Anda yakin ingin keluar dari kost ini?');">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-out-alt"></i> Keluar dari Kost
                        </button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-info-circle fa-2x"></i>
                        </div>
                        <div>
                            Anda belum memiliki kost aktif. 
                            <a href="/cari-kost" class="alert-link">Cari kost sekarang!</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Complaint Submission Card -->
        <?php if(isset($data['activeBooking']) && $data['activeBooking']): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Ajukan Keluhan</h5>
                </div>
                <div class="card-body">
                    <form action="/complaint/submit" method="POST">
                        <input type="hidden" name="booking_id" value="<?php echo $data['activeBooking']['id']; ?>">
                        <input type="hidden" name="kost_id" value="<?php echo $data['activeBooking']['kost_id']; ?>">
                        
                        <div class="form-group">
                            <label for="complaint_text">Keluhan Anda:</label>
                            <textarea class="form-control" id="complaint_text" name="complaint_text" 
                                      rows="3" required placeholder="Tuliskan keluhan Anda di sini..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-exclamation-circle"></i> Kirim Keluhan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Complaint History Card -->
            <?php if(isset($data['complaints']) && !empty($data['complaints'])): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Riwayat Keluhan</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach($data['complaints'] as $complaint): ?>
                            <div class="alert alert-secondary">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Tanggal: <?php echo date('d F Y', strtotime($complaint['created_at'])); ?></strong>
                                    <span class="badge complaint-status-badge badge-<?php echo $complaint['status'] === 'resolved' ? 'success' : 
                                        ($complaint['status'] === 'in_progress' ? 'warning' : 'danger'); ?>">
                                        <?php echo ucfirst($complaint['status']); ?>
                                    </span>
                                </div>
                                <p><?php echo htmlspecialchars($complaint['complaint_text']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Navigation Links -->
        <div class="card nav-custom">
            <div class="card-body p-0">
                <nav class="nav flex-column">
                    <!-- <a class="nav-link py-3 border-bottom" href="/"><i class="fas fa-home mr-2"></i> Home</a> -->
                    <a class="nav-link py-3 border-bottom" href="/kost"><i class="fas fa-building mr-2"></i> Manage Kost</a>
                    <!-- <a class="nav-link py-3 border-bottom" href="/profile"><i class="fas fa-user mr-2"></i> Profil</a> -->
                    <!-- <a class="nav-link py-3 border-bottom" href="/settings"><i class="fas fa-cog mr-2"></i> Pengaturan</a> -->
                    <a class="nav-link py-3 text-danger" href="/logout"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>