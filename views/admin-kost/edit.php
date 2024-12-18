<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include __DIR__."/../navbar.php"; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Edit Data Kost</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form class="container" method="POST" action="">
            <div class="mb-3">
                <label for="nama_kost" class="form-label">Nama Kost</label>
                <input type="text" class="form-control" id="nama_kost" name="nama_kost" value="<?php echo htmlspecialchars($kost['nama_kost']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" required><?php echo htmlspecialchars($kost['alamat']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo htmlspecialchars($kost['latitude']); ?>">
            </div>

            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo htmlspecialchars($kost['longitude']); ?>">
            </div>

            <div class="mb-3">
                <label for="deskripsi_umum" class="form-label">Deskripsi Umum</label>
                <textarea class="form-control" id="deskripsi_umum" name="deskripsi_umum"><?php echo htmlspecialchars($kost['deskripsi_umum']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="tipe_kost" class="form-label">Tipe Kost</label>
                <input type="text" class="form-control" id="tipe_kost" name="tipe_kost" value="<?php echo htmlspecialchars($kost['tipe_kost']); ?>">
            </div>

            <div class="mb-3">
                <label for="jam_bertamu" class="form-label">Jam Bertamu</label>
                <input type="text" class="form-control" id="jam_bertamu" name="jam_bertamu" value="<?php echo htmlspecialchars($kost['jam_bertamu']); ?>">
            </div>

            <div class="mb-3">
              <label for="aturan_kost" class="form-label">Aturan Kost</label>
                <textarea class="form-control" id="aturan_kost" name="aturan_kost"><?php echo htmlspecialchars($kost['aturan_kost']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="kontak_pemilik" class="form-label">Kontak Pemilik</label>
                <input type="text" class="form-control" id="kontak_pemilik" name="kontak_pemilik" value="<?php echo htmlspecialchars($kost['kontak_pemilik']); ?>">
            </div>

            <div class="mb-3">
                <label for="email_pemilik" class="form-label">Email Pemilik</label>
                <input type="email" class="form-control" id="email_pemilik" name="email_pemilik" value="<?php echo htmlspecialchars($kost['email_pemilik']); ?>">
            </div>

            <div class="mb-3">
                <label for="kamar_tersedia" class="form-label">Kamar Tersedia</label>
                <input type="number" class="form-control" id="kamar_tersedia" name="kamar_tersedia" value="<?php echo htmlspecialchars($kost['kamar_tersedia']); ?>">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Update Data</button>
                <a href="/kost" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>