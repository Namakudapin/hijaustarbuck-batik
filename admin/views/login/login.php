<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: /admin/views/dashboard/dashboard.php");
    exit();
}

require_once dirname(__FILE__) . '/../../../controllers/AdminController.php';

$adminController = new AdminController();

$message = ''; // To hold any error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging output
    echo "Email yang dimasukkan: " . $_POST['email'] . "<br>";
    echo "Password yang dimasukkan: " . $_POST['password'] . "<br>";
    
    // Call the login method with POST data (email and password)
    $message = $adminController->login($_POST['email'], $_POST['password']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/login.css/style.css">
    <title>Masuk Admin</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <div class="logo" style="text-align: center; margin-bottom: 20px;">
                <img src="/assets/image/logo.png" alt="IT Solution Logo" style="width: 150px;">
            </div>
            <header>Masuk Admin</header>

            <!-- Display error message if login fails -->
            <?php if ($message) { echo "<p style='color:red;'>$message</p>"; } ?>

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
        Login sebagai user? <a href="/views/login/login.php">Klik di sini</a>
    </div>
</form>

        </div>
    </div>
</body>
</html>
