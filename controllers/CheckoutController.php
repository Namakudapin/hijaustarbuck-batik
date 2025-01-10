<?php
require_once dirname(__DIR__) . '/models/CheckoutModel.php';
require_once dirname(__DIR__) . '/services/services.php';
require_once dirname(__DIR__) . '/controllers/SendEmail.php';

class CheckoutController {
    private $checkoutModel;
    private $uploadDir;

    public function __construct() {
        $this->checkoutModel = new CheckoutModel();
        $this->uploadDir = dirname(__DIR__) . '/public/uploads/transfer_proofs/';

        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function index() {
        $checkouts = $this->checkoutModel->index();
        return $checkouts;
    }


    public function createCheckout() {
        try {
            $user_id = $_POST['user_id'];
            $paket_id = $_POST['paket_id'];
            $email = $_POST['email'];
            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            if (!isset($_FILES['transfer_proof']) || $_FILES['transfer_proof']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("No file uploaded or upload error occurred.");
            }

            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($file_info, $_FILES['transfer_proof']['tmp_name']);
            finfo_close($file_info);

            if (!in_array($mime_type, $allowed_types)) {
                throw new Exception("Invalid file type. Only JPG, PNG, and PDF files are allowed.");
            }

            $extension = pathinfo($_FILES['transfer_proof']['name'], PATHINFO_EXTENSION);
            $filename = 'transfer_' . uniqid() . '.' . $extension;
            $filepath = $this->uploadDir . $filename;

            if (!move_uploaded_file($_FILES['transfer_proof']['tmp_name'], $filepath)) {
                throw new Exception("Failed to upload file. Please try again.");
            }

            $relative_path = '/public/uploads/transfer_proofs/' . $filename;

            if ($this->checkoutModel->createCheckout($user_id, $paket_id, $email, $relative_path, $created_at, $updated_at)) {
                $subject = 'Checkout Confirmation';
                $message = "<h1>Thank you for your purchase!</h1><p>Your checkout has been successfully recorded.</p>";
                
                sendEmail($email, $subject, $message);
                header('Location: success.php');
                exit;
            } else {
                throw new Exception("Failed to create checkout record.");
            }
        } catch (Exception $e) {
            error_log("Checkout Error: " . $e->getMessage());
            die($e->getMessage());
        }
    }

    public function getCheckoutById() {
        $id = $_GET['id'];
        $result = $this->checkoutModel->getCheckoutById($id);

        if ($result && mysqli_num_rows($result) > 0) {
            $checkout = mysqli_fetch_assoc($result);
            echo json_encode($checkout);
        } else {
            echo "No checkout found with the given ID.";
        }
    }

    public function updateCheckoutStatus() {
        try {
            if (!isset($_POST['id']) || !isset($_POST['status'])) {
                throw new Exception("Invalid data received.");
            }
    
            $id = intval($_POST['id']);
            $status = trim($_POST['status']);
            $updated_at = date('Y-m-d H:i:s');
    
            if ($this->checkoutModel->updateCheckout($id, $status, $updated_at)) {
                $result = $this->checkoutModel->getCheckoutById($id);
                if ($result && mysqli_num_rows($result) > 0) {
                    $checkout = mysqli_fetch_assoc($result);
                    $email = $checkout['email'];
    
                    $subject = 'Checkout Status Update';
                    $message = "<h1>Checkout Status Updated</h1><p>Your checkout status has been updated to: {$status}</p>";
    
                    if (sendEmail($email, $subject, $message)) {
                        echo json_encode(['success' => true, 'message' => 'Status updated and email sent successfully!']);
                    } else {
                        echo json_encode(['success' => true, 'message' => 'Status updated, but email failed to send.']);
                    }
                } else {
                    echo json_encode(['success' => true, 'message' => 'Status updated, but email address not found.']);
                }
            } else {
                throw new Exception("Failed to update status.");
            }
        } catch (Exception $e) {
            error_log("Error in updateCheckoutStatus: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    

    public function getCheckoutsByUserId() {
        try {
            if (!isset($_GET['user_id'])) {
                throw new Exception("User ID is required.");
            }
    
            $user_id = intval($_GET['user_id']);
            $result = $this->checkoutModel->getCheckoutByUserId($user_id);
    
            if ($result && mysqli_num_rows($result) > 0) {
                $checkouts = [];
                require_once dirname(__DIR__) . '/models/PaketModel.php';
                $paketModel = new PaketModel();
    
                while ($row = mysqli_fetch_assoc($result)) {
                    // Fetch Paket Details by paket_id
                    $paketData = $paketModel->GetById($row['paket_id']);
                    $paket = mysqli_fetch_assoc($paketData);
    
                    // Merge Paket Name and Expired Date into Checkout Data
                    $row['paket_name'] = $paket['title'] ?? 'Unknown Package';
                    $row['expired_at'] = $row['expired_at'] ?? $paket['expired_at'] ?? null;
    
                    $checkouts[] = $row;
                }
    
                echo json_encode($checkouts);
            } else {
                echo json_encode(['message' => 'No checkouts found for the given user.']);
            }
        } catch (Exception $e) {
            error_log("Error in getCheckoutsByUserId: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    

    public function deleteCheckout() {
        try {
            if (!isset($_POST['id'])) {
                throw new Exception("Invalid ID.");
            }
    
            $id = intval($_POST['id']);
            if ($this->checkoutModel->deleteCheckout($id)) {
                echo json_encode(['success' => true, 'message' => 'Checkout deleted successfully.']);
            } else {
                throw new Exception("Failed to delete checkout.");
            }
        } catch (Exception $e) {
            error_log("Delete Error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
}   
