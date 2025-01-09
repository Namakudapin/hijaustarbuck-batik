<?php
session_start();

// If user is already logged in, redirect to service page
if (isset($_SESSION['user_id'])) {
    header("Location: /views/service/service.php");
    exit();
}

require_once dirname(__FILE__) . '/../../controllers/AuthController.php';

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->login();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/login.css/style.css">
    <title>Masuk</title>
</head>
<body>
    <div class="container">
        
        <div class="box form-box">
        <div class="logo" style="text-align: center; margin-bottom: 20px;">
                <img src="/assets/image/logo.png" alt="IT Solution Logo" style="width: 150px;">
            </div>
            <header>Masuk</header>
                <form action="" method="post">
            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="off" required>
            </div>

            <div class="field input">
                <label for="password">Kata sandi</label>
                <input type="password" name="password" id="password" autocomplete="off" required>
            </div>

            <div class="field">
                <input type="submit" class="btn" name="submit" value="Masuk" required>
            </div>

            <div class="links">
                Belum mempunyai akun? <a href="/views/register/register.php">Daftar</a><br>
                Login sebagai admin? <a href="/admin/views/login/login.php">Klik di sini</a>
            </div>
        </form>

        </div>
    </div>
</body>
</html>
