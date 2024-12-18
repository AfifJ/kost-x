<!DOCTYPE html>
<html>
<head>
    <title>Halaman Tidak Ditemukan</title>
</head>
<body>
    <h1>404 - Halaman Tidak Ditemukan</h1>
    <p>Maaf, halaman yang Anda cari tidak tersedia.</p>
    <?php if (!isLoggedIn()): ?>
        <p><a href="/login">Kembali ke Login</a></p>
    <?php else: ?>
        <p><a href="/dashboard">Kembali ke Dashboard</a></p>
    <?php endif; ?>
</body>
</html>