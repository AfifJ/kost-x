<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kost</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<?php include __DIR__."/../navbar.php" ?>
<div class="container">
    <h2 class="my-4">Daftar Kost</h2>
    <a href="/dashboard" class="btn btn-primary mb-3">Dashboard</a>
    <a href="/kost/create" class="btn btn-success mb-3">Tambah Kost</a>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nama Kost</th>
                <th>Alamat</th>
                <th>Kamar Tersedia</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($kosts as $kost): ?>
            <tr>
                <td><?php echo htmlspecialchars($kost['nama_kost']); ?></td>
                <td><?php echo htmlspecialchars($kost['alamat']); ?></td>
                <td><?php echo htmlspecialchars($kost['kamar_tersedia']); ?></td>
                <td>
                    <a href="/kost/detail?id=<?php echo $kost['id']; ?>" class="btn btn-info">Detail</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
