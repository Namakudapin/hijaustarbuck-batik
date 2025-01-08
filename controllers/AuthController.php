<?php
// File: controllers/AuthController.php
include dirname(__DIR__) . '/services/services.php';
include dirname(__DIR__) . '/models/AuthModel.php';

class AuthController {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    public function login() {
        // Validate input
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $_SESSION['error'] = "Please fill in all fields";
            return false;
        }

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $user = $this->authModel->loginUser($email, $password);

        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            $_SESSION['success'] = "Login successful!";
            header('Location: views/service/service.php');
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header('Location: /views/login/login.php');
            exit();
        }
    }

    public function register() {
        // Validate input
        if (!isset($_POST['email']) || !isset($_POST['username']) || 
            !isset($_POST['password']) || !isset($_POST['password_confirm'])) {
            $_SESSION['error'] = "Please fill in all fields";
            return false;
        }

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        $result = $this->authModel->registerUser($email, $username, $password, $password_confirm);

        if ($result === true) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: /views/login/login.php");
            exit();
        } else {
            $_SESSION['error'] = $result;
            header("Location: /views/register/register.php");
            exit();
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /views/login/login.php');
        exit();
    }
}