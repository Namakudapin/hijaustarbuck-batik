<?php
session_start();

require_once dirname(__FILE__) . '/../../controllers/AuthController.php';

// Instansiasi AuthController
$authController = new AuthController();

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Panggil fungsi login di AuthController
    $result = $authController->login($email, $password);

    if ($result === true) {
        // Jika login berhasil, arahkan ke halaman home
        header('Location: /views/pages/home/home.php');
        exit();
    } else {
        // Jika login gagal, simpan pesan error di session
        $_SESSION['login_error'] = $result;
        header('Location: login.php'); // Kembali ke halaman login
        exit();
    }
}
?>
