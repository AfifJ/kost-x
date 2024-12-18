<!DOCTYPE html>
<html>
<head>
    <title>Cari Kost</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-size: 14px;
        }
        .kost-item {
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .kost-item:hover {
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            background-color: #f8f9fa;
        }
        .kost-name {
            color: #1a73e8;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .kost-address {
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .kost-info {
            color: #666;
            font-size: 14px;
        }
        .search-container {
            margin: 30px 0;
            max-width: 600px;
        }
        .badge {
            font-size: 14px;
            padding: 8px 12px;
            margin-right: 5px;
        }
        .form-control {
            font-size: 16px;
            padding: 12px;
        }
        .btn {
            font-size: 16px;
        }
    </style>
</head>
<body>
<?php include "../navbar.php"?>

<div class="container">
    <h2 class="my-4">Cari Kost</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php if ($_GET['error'] === 'already_booked'): ?>
                Anda sudah menjadi penghuni kost. Tidak dapat memesan kamar lagi.
            <?php else: ?>
                Terjadi kesalahan saat memesan kamar.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            Pemesanan kamar berhasil!
        </div>
    <?php endif; ?>

    <?php if (isset($activeBooking)): ?>
        <div class="alert alert-info">
            <strong>Status:</strong> Penghuni Kost <?php echo htmlspecialchars($activeBooking['nama_kost']); ?>
        </div>
    <?php endif; ?>

    <div class="search-container">
        <form method="GET" action="/cari-kost">
            <div class="input-group">
                <input type="text" class="form-control" id="alamat" name="alamat" 
                       placeholder="Cari kost berdasarkan lokasi..." 
                       value="<?php echo isset($_GET['alamat']) ? htmlspecialchars($_GET['alamat']) : ''; ?>" required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
    </div>

    <?php if (isset($results)): ?>
        <div class="search-results">
            <?php if (empty($results)): ?>
                <p class="text-muted">Tidak ada kost yang ditemukan.</p>
            <?php else: ?>
                <?php foreach($results as $kost): ?>
                    <div class="kost-item" onclick="window.location.href='/cari-kost/detail?id=<?php echo $kost['id']; ?>'">
                        <div class="kost-name"><?php echo htmlspecialchars($kost['nama_kost']); ?></div>
                        <div class="kost-address">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo htmlspecialchars($kost['alamat']); ?>
                        </div>
                        <div class="kost-info">
                            <span class="badge badge-info"><?php echo htmlspecialchars($kost['tipe_kost']); ?></span>
                            <span class="badge <?php echo $kost['kamar_tersedia'] > 0 ? 'badge-success' : 'badge-danger'; ?>">
                                <?php echo $kost['kamar_tersedia'] > 0 ? 
                                      $kost['kamar_tersedia'] . ' kamar tersedia' : 
                                      'Kamar penuh'; ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
