<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kost Baru</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>


<div class="container">

    <h2 class="my-4">Tambah Kost Baru</h2>

    <?php 
    // Tampilkan pesan error jika ada
    if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/kost/create" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama_kost">Nama Kost</label>
            <input type="text" class="form-control" id="nama_kost" name="nama_kost" 
                   value="<?php echo isset($nama_kost) ? htmlspecialchars($nama_kost) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" required><?php echo isset($alamat) ? htmlspecialchars($alamat) : ''; ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="number" class="form-control" id="latitude" name="latitude" 
                           value="<?php echo isset($latitude) ? htmlspecialchars($latitude) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="number" class="form-control" id="longitude" name="longitude" 
                           value="<?php echo isset($longitude) ? htmlspecialchars($longitude) : ''; ?>" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="deskripsi_umum">Deskripsi Umum</label>
            <textarea class="form-control" id="deskripsi_umum" name="deskripsi_umum"><?php echo isset($deskripsi_umum) ? htmlspecialchars($deskripsi_umum) : ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="tipe_kost">Tipe Kost</label>
            <select class="form-control" id="tipe_kost" name="tipe_kost" required>
                <option value="">Select one...</option>
                <option value="putra">Putra</option>
                <option value="putri">Putri</option>
                <option value="campur">Campur</option>
            </select>
        </div>

        <div class="form-group">
            <label for="jam_bertamu">Jam Bertamu</label>
            <input type="time" class="form-control" id="jam_bertamu" name="jam_bertamu" 
                   value="<?php echo isset($jam_bertamu) ? htmlspecialchars($jam_bertamu) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="aturan_kost">Aturan Kost</label>
            <textarea class="form-control" id="aturan_kost" name="aturan_kost"><?php echo isset($aturan_kost) ? htmlspecialchars($aturan_kost) : ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="kontak_pemilik">Kontak Pemilik</label>
            <input type="text" class="form-control" id="kontak_pemilik" name="kontak_pemilik" 
                   value="<?php echo isset($kontak_pemilik) ? htmlspecialchars($kontak_pemilik) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="email_pemilik">Email Pemilik</label>
            <input type="email" class="form-control" id="email_pemilik" name="email_pemilik" 
                   value="<?php echo isset($email_pemilik) ? htmlspecialchars($email_pemilik) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="kamar_tersedia">Kamar Tersedia</label>
            <input type="number" class="form-control" id="kamar_tersedia" name="kamar_tersedia" 
                   value="<?php echo isset($kamar_tersedia) ? htmlspecialchars($kamar_tersedia) : ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="foto_kost">Foto Kost</label>
            <input type="file" class="form-control-file" id="foto_kost" name="foto_kost" required>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Kost</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
