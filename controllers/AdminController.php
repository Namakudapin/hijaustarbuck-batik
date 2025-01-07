<?php 
include dirname(__DIR__) . '/services/services.php';
include dirname(__DIR__) . '/models/AdminModel.php';

class AdminController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }


     public function login($email, $password)
     {
         $admin = $this->adminModel->loginUser($email, $password);
         if ($admin) {
             session_start();
             $_SESSION['admin_id'] = $admin['id'];
             $_SESSION['admin_email'] = $admin['email'];
             $_SESSION['admin_username'] = $admin['username'];
             header('Location: ../');
             exit();
         } else {
             return "Email atau Password salah!";
         }
     }
 
     public function register($email, $username, $password, $password_confirm)
     {
         $message = $this->adminModel->registerUser($email, $username, $password, $password_confirm);
         return $message;
     }
 
     public function logout()
     {
         session_start();
         session_destroy();
         header('Location: /');
         exit();
     }
 
     
     public function handleLoginForm($email, $password)
     {
         return $this->login($email, $password);
     }
 
     public function handleRegisterForm()
     {
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $email = $_POST['email'];
             $username = $_POST['username'];
             $password = $_POST['password'];
             $password_confirm = $_POST['password_confirm'];
             $message = $this->register($email, $username, $password, $password_confirm);
 
             if ($message) {
                 exit();
             }
         }
     }
     public function handleAction()
     {
         if (isset($_GET['action'])) {
             switch ($_GET['action']) {
                 case 'logout':
                     $this->logout();
                     break;
             }
         }
     }
}
?>