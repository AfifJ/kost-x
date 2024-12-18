<!DOCTYPE html>
<html>
<head>
    <title>Detail Kost</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .features-list { list-style: none; padding-left: 0; }
        .features-list li { margin-bottom: 10px; }
        .features-list i { margin-right: 10px; color: #28a745; }
        .booking-card { position: sticky; top: 20px; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php include "../navbar.php"?>

    <div class="container my-4">
        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">
                Pemesanan kamar berhasil! Silahkan hubungi pemilik kost untuk informasi lebih lanjut.
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    $error_msg = "Terjadi kesalahan dalam pemesanan.";
                    if($_GET['error'] === 'already_booked') {
                        $error_msg = "Anda sudah memiliki pemesanan aktif!";
                    }
                    echo $error_msg;
                ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Detail Kost -->
            <div class="col-lg-8">
                <h2 class="mb-4"><?php echo htmlspecialchars($kost['nama_kost']); ?></h2>
                
                <!-- Gambar Kost (jika ada) -->
                <?php if(isset($kost['foto']) && $kost['foto']): ?>
                    <img src="/uploads/kost/<?php echo htmlspecialchars($kost['foto']); ?>" 
                         class="img-fluid rounded mb-4" alt="Foto Kost">
                <?php endif; ?>

                <!-- Informasi Utama -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Utama</h5>
                        <ul class="features-list">
                            <li><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($kost['alamat']); ?></li>
                            <li><i class="fas fa-home"></i> Tipe: <?php echo htmlspecialchars($kost['tipe_kost']); ?></li>
                            <li><i class="fas fa-door-open"></i> Kamar Tersedia: <?php echo htmlspecialchars($kost['kamar_tersedia']); ?></li>
                            <li><i class="fas fa-clock"></i> Jam Bertamu: <?php echo htmlspecialchars($kost['jam_bertamu']); ?></li>
                        </ul>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Deskripsi</h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($kost['deskripsi_umum'])); ?></p>
                    </div>
                </div>

                <!-- Aturan Kost -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Aturan Kost</h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($kost['aturan_kost'])); ?></p>
                    </div>
                </div>
            </div>

            <!-- Sidebar Pemesanan -->
            <div class="col-lg-4">
                <div class="card booking-card">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Pemesanan</h5>
                        
                        <?php if($kost['kamar_tersedia'] > 0): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> <?php echo $kost['kamar_tersedia']; ?> Kamar Tersedia
                            </div>
                            
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <?php if(!isset($activeBooking)): ?>
                                    <form action="/kost/book" method="POST">
                                        <input type="hidden" name="kost_id" value="<?php echo $kost['id']; ?>">
                                        <button type="submit" class="btn btn-success btn-lg btn-block">
                                            <i class="fas fa-book"></i> Pesan Kamar Sekarang
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-circle"></i> Anda sudah memiliki pemesanan aktif
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Silakan <a href="/login">login</a> untuk melakukan pemesanan
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle"></i> Kamar Penuh
                            </div>
                        <?php endif; ?>

                        <!-- Kontak Pemilik -->
                        <div class="mt-4">
                            <h6>Kontak Pemilik:</h6>
                            <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($kost['kontak_pemilik']); ?></p>
                            <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($kost['email_pemilik']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="/cari-kost" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Pencarian
            </a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
