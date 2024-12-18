<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Selamat Datang, <?= htmlspecialchars($data['username']) ?></h1>
    <p>Kamu adalah seorang <?= $data['user_type'] ?></p>
    <div class="stats">
        <!-- Tampilkan statistik -->
    </div>
    
    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/profile">Profil</a></li>
            <li><a href="/settings">Pengaturan</a></li>
            <li><a href="/logout">Logout</a></li>
        </ul>
    </nav>
</body>
</html>