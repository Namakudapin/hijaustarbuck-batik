<?php
include dirname(__DIR__) . '/models/PaketUserModel.php';

class PaketUserController
{
    private $paketUserModel;

    public function __construct()
    {
        $this->paketUserModel = new PaketUserModel();
    }

    // Create a new Paket Us    er
    public function createPaketUser()
    {
        $user_id = $_POST['user_id'];
        $checkout_id = $_POST['checkout_id'];
        $title = $_POST['title'];
        $domain = $_POST['domain'];
        $status = $_POST['status'];
        $expired_at = $_POST['expired_at'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;

        // Check if the domain already exists
        if ($this->paketUserModel->isDomainExists($domain)) {
            echo "Domain already exists! Please choose a different domain.";
            return;
        }

        if ($this->paketUserModel->createPaketUser($user_id, $checkout_id, $title, $domain, $status, $expired_at, $created_at, $updated_at)) {
            echo "Paket User created successfully!";
        } else {
            echo "Failed to create Paket User.";
        }
    }

    // Get Paket User by ID
    public function getPaketUserById()
    {
        $id = $_GET['id'];
        $result = $this->paketUserModel->getPaketUserById($id);

        if ($result && mysqli_num_rows($result) > 0) {
            $paketUser = mysqli_fetch_assoc($result);
            echo json_encode($paketUser);
        } else {
            echo "No Paket User found with the given ID.";
        }
    }

    // Get Paket Users by User ID
    public function getPaketUsersByUserId()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        
        if (!$user_id) {
            echo "Debug: No user_id found in session";
            return json_encode([]);
        }
    
        $result = $this->paketUserModel->getPaketUserByUserId($user_id);
        
        // Debug: Print the SQL error if any
        if (!$result) {
            echo "MySQL Error: " . mysqli_error($GLOBALS['conn']);
        }
        
        if ($result && mysqli_num_rows($result) > 0) {
            $paketUsers = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $paketUsers[] = $row;
            }
            // Debug: Print the data
            echo "Debug: Found " . count($paketUsers) . " records";
            return json_encode($paketUsers);
        } else {
            echo "Debug: No records found";
            return json_encode([]);
        }
    }

    // Update Paket User
    public function updatePaketUser()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $expired_at = $_POST['expired_at'];
        $updated_at = date('Y-m-d H:i:s');

        if ($this->paketUserModel->updatePaketUser($id, $status, $expired_at, $updated_at)) {
            echo "Paket User updated successfully!";
        } else {
            echo "Failed to update Paket User.";
        }
    }

    // Delete Paket User
    public function deletePaketUser()
    {
        $id = $_POST['id'];

        if ($this->paketUserModel->deletePaketUser($id)) {
            echo "Paket User deleted successfully!";
        } else {
            echo "Failed to delete Paket User.";
        }
    }
}
