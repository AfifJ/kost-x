<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($data['title']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($data['title']) ?></h1>
    <p><?= htmlspecialchars($data['description']) ?></p>
    
    <?php if (!isLoggedIn()): ?>
        <a href="/login">Login</a>
        <a href="/register">Daftar</a>
    <?php else: ?>
        <a href="/dashboard">Masuk Dashboard</a>
    <?php endif; ?>
</body>
</html>