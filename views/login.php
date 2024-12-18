<?php
$errors = $errors ?? [];
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="/login">
        <input type="email" 
               name="email" 
               placeholder="Email" 
               required 
               value="<?= $email ?>"
        ><br>
        <input type="password" 
               name="password" 
               placeholder="Password" 
               required
               value="<?= $password ?>"
        ><br>
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="/register">Daftar</a></p>
</body>
</html>