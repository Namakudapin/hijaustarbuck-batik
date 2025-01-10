<?php
require_once dirname(__DIR__) . '/models/CheckoutModel.php';
require_once dirname(__DIR__) . '/services/services.php';
require_once dirname(__DIR__) . '/controllers/SendEmail.php';

class CheckoutController
{
    private $checkoutModel;
    private $uploadDir;

    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
        $this->uploadDir = dirname(__DIR__) . '/public/uploads/transfer_proofs/';

        // Ensure upload directory exists
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function index()
    {
        $checkouts = $this->checkoutModel->index();
        return $checkouts;
    }

    public function createCheckout()
    {
        try {
            $user_id = $_POST['user_id'];
            $paket_id = $_POST['paket_id'];
            $email = $_POST['email'];
            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            // Handle file upload
            if (!isset($_FILES['transfer_proof']) || $_FILES['transfer_proof']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("No file uploaded or upload error occurred.");
            }

            // Validate file type
            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($file_info, $_FILES['transfer_proof']['tmp_name']);
            finfo_close($file_info);

            if (!in_array($mime_type, $allowed_types)) {
                throw new Exception("Invalid file type. Only JPG, PNG, and PDF files are allowed.");
            }

            // Generate safe filename
            $extension = pathinfo($_FILES['transfer_proof']['name'], PATHINFO_EXTENSION);
            $filename = 'transfer_' . uniqid() . '.' . $extension;
            $filepath = $this->uploadDir . $filename;

            // Move the uploaded file
            if (!move_uploaded_file($_FILES['transfer_proof']['tmp_name'], $filepath)) {
                throw new Exception("Failed to upload file. Please try again.");
            }

            // Store relative path in database
            $relative_path = '/public/uploads/transfer_proofs/' . $filename;

            // Create checkout record
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
            // Log error for debugging
            error_log("Checkout Error: " . $e->getMessage());
            die($e->getMessage());
        }
    }

    public function getCheckoutById()
    {
        $id = $_GET['id'];
        $result = $this->checkoutModel->getCheckoutById($id);

        if ($result && mysqli_num_rows($result) > 0) {
            $checkout = mysqli_fetch_assoc($result);
            echo json_encode($checkout);
        } else {
            echo "No checkout found with the given ID.";
        }
    }
    public function updateCheckoutStatus()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $updated_at = date('Y-m-d H:i:s');

        if ($this->checkoutModel->updateCheckout($id, $status, $updated_at)) {
            // Fetch the checkout details to get the email
            $result = $this->checkoutModel->getCheckoutById($id);
            if ($result && mysqli_num_rows($result) > 0) {
                $checkout = mysqli_fetch_assoc($result);
                $email = $checkout['email'];

                // Send an email to notify about the status update
                $subject = 'Checkout Status Update';
                $message = "<h1>Checkout Status Updated</h1><p>Your checkout status has been updated to: {$status}</p>";

                if (sendEmail($email, $subject, $message)) {
                    echo "Status updated and email sent successfully!";
                } else {
                    echo "Status updated, but email failed to send.";
                }
            } else {
                echo "Status updated, but email address not found.";
            }
        } else {
            echo "Failed to update status.";
        }
    }

    // List checkouts by user ID
    public function getCheckoutsByUserId()
    {
        $user_id = $_GET['user_id'];
        $result = $this->checkoutModel->getCheckoutByUserId($user_id);

        if ($result && mysqli_num_rows($result) > 0) {
            $checkouts = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $checkouts[] = $row;
            }
            echo json_encode($checkouts);
        } else {
            echo "No checkouts found for the given user.";
        }
    }
}
