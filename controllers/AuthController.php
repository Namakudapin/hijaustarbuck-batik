<?php
// File: controllers/AuthController.php
include dirname(__DIR__) . '/services/services.php';
include dirname(__DIR__) . '/models/AuthModel.php';

class AuthController
{
    private $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->authModel->loginUser($email, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: /');
        } else {
            echo "Login gagal!";
        }
    }

    public function register()
    {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        $result = $this->authModel->registerUser($email, $username, $password, $password_confirm);

        if ($result === true) {
            header("Location: /views/login/login.php");
            exit;
        } else {
            echo "<script>alert('$result');</script>";
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
}
