<!DOCTYPE html>
<html>
<head>
    <title>Detail Kost</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>


<div class="container">
    <h2 class="my-4">Detail Kost</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($kost['nama_kost']); ?></h5>
            <div class="alert alert-info">
                <strong>Status Kamar:</strong> 
                <?php echo $kost['kamar_tersedia'] > 0 ? 
                      $kost['kamar_tersedia'] . ' kamar tersedia' : 
                      'Kamar penuh'; ?>
            </div>
            
            <!-- <?php if(!isset($activeBooking) && $kost['kamar_tersedia'] > 0): ?>
                <form action="/kost/book" method="POST" class="mb-3">
                    <input type="hidden" name="kost_id" value="<?php echo $kost['id']; ?>">
                    <button type="submit" class="btn btn-success btn-lg">Pesan Kamar Sekarang</button>
                </form>
            <?php endif; ?> -->

            <p class="card-text"><strong>Alamat:</strong> <?php echo htmlspecialchars($kost['alamat']); ?></p>
            <p class="card-text"><strong>Latitude:</strong> <?php echo htmlspecialchars($kost['latitude']); ?></p>
            <p class="card-text"><strong>Longitude:</strong> <?php echo htmlspecialchars($kost['longitude']); ?></p>
            <p class="card-text"><strong>Deskripsi Umum:</strong> <?php echo htmlspecialchars($kost['deskripsi_umum']); ?></p>
            <p class="card-text"><strong>Tipe Kost:</strong> <?php echo htmlspecialchars($kost['tipe_kost']); ?></p>
            <p class="card-text"><strong>Jam Bertamu:</strong> <?php echo htmlspecialchars($kost['jam_bertamu']); ?></p>
            <p class="card-text"><strong>Aturan Kost:</strong> <?php echo htmlspecialchars($kost['aturan_kost']); ?></p>
            <p class="card-text"><strong>Kontak Pemilik:</strong> <?php echo htmlspecialchars($kost['kontak_pemilik']); ?></p>
            <p class="card-text"><strong>Email Pemilik:</strong> <?php echo htmlspecialchars($kost['email_pemilik']); ?></p>
            <p class="card-text"><strong>Kamar Tersedia:</strong> <?php echo htmlspecialchars($kost['kamar_tersedia']); ?></p>
            <a href="/kost/edit?id=<?php echo $kost['id']; ?>" class="btn btn-warning">Edit</a>
            <a href="/kost/hapus?id=<?php echo $kost['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
            <a href="/kost" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <?php if (!empty($kost['complaints'])): ?>
        <h3 class="my-4">Riwayat Keluhan</h3>
        <div class="card">
            <div class="card-body">
                <?php foreach ($kost['complaints'] as $complaint): ?>
                    <div class="alert alert-secondary">
                        <strong>Keluhan:</strong> <?php echo htmlspecialchars($complaint['complaint_text']); ?><br>
                        <strong>Status:</strong> <?php echo htmlspecialchars($complaint['status']); ?><br>
                        <strong>Tanggal:</strong> <?php echo htmlspecialchars($complaint['created_at']); ?><br>
                        <?php if($complaint['status'] != 'resolved'): ?>
                        <form action="/complaint/update-status" method="POST" class="d-inline">
                            <input type="hidden" name="complaint_id" value="<?php echo $complaint['id']; ?>">
                            <input type="hidden" name="status" value="resolved">
                            <button type="submit" class="btn btn-success btn-sm">Tandai Selesai</button>
                        </form>
                        <?php endif ?>
                        <form action="/complaint/delete" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus keluhan ini?')">
                            <input type="hidden" name="complaint_id" value="<?php echo $complaint['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>