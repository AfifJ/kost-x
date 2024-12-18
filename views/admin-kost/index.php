<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kost</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>


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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
