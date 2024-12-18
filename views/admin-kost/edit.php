<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Kost</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 8px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        .btn-kembali {
            background-color: #f44336;
        }
    </style>
</head>
<body>


    <h2>Edit Data Kost</h2>
    
    <?php if(isset($error)): ?>
        <div style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Nama Kost</label>
            <input type="text" name="nama_kost" value="<?php echo htmlspecialchars($kost['nama_kost']); ?>" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" required><?php echo htmlspecialchars($kost['alamat']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Latitude</label>
            <input type="text" name="latitude" value="<?php echo htmlspecialchars($kost['latitude']); ?>">
        </div>

        <div class="form-group">
            <label>Longitude</label>
            <input type="text" name="longitude" value="<?php echo htmlspecialchars($kost['longitude']); ?>">
        </div>

        <div class="form-group">
            <label>Deskripsi Umum</label>
            <textarea name="deskripsi_umum"><?php echo htmlspecialchars($kost['deskripsi_umum']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Tipe Kost</label>
            <input type="text" name="tipe_kost" value="<?php echo htmlspecialchars($kost['tipe_kost']); ?>">
        </div>

        <div class="form-group">
            <label>Jam Bertamu</label>
            <input type="text" name="jam_bertamu" value="<?php echo htmlspecialchars($kost['jam_bertamu']); ?>">
        </div>

        <div class="form-group">
            <label>Aturan Kost</label>
            <textarea name="aturan_kost"><?php echo htmlspecialchars($kost['aturan_kost']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Kontak Pemilik</label>
            <input type="text" name="kontak_pemilik" value="<?php echo htmlspecialchars($kost['kontak_pemilik']); ?>">
        </div>

        <div class="form-group">
            <label>Email Pemilik</label>
            <input type="email" name="email_pemilik" value="<?php echo htmlspecialchars($kost['email_pemilik']); ?>">
        </div>

        <div class="form-group">
            <label>Kamar Tersedia</label>
            <input type="number" name="kamar_tersedia" value="<?php echo htmlspecialchars($kost['kamar_tersedia']); ?>">
        </div>

        <div class="form-group">
            <button type="submit" class="btn">Update Data</button>
            <a href="/kost" class="btn btn-kembali">Kembali</a>
        </div>
    </form>
</body>
</html>