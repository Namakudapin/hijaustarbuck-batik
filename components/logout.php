<?php
include dirname(__DIR__) . '/controllers/AuthController.php';

$authController = new AuthController();
$authController->logout(); // Panggil metode logout
