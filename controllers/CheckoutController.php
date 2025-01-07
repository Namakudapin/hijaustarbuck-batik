<?php
include dirname(__DIR__) . '/models/CheckoutModel.php';
include dirname(__DIR__) . '/services/services.php';

class CheckoutController {
    private $checkoutModel;

    public function __construct() {
        $this->checkoutModel = new CheckoutModel();
    }

    // Create a new checkout entry
    public function createCheckout() {
        $user_id = $_POST['user_id'];
        $paket_id = $_POST['paket_id'];
        $email = $_POST['email'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;

        if ($this->checkoutModel->createCheckout($user_id, $paket_id, $email, $created_at, $updated_at)) {
            // Send an email to the user upon successful checkout
            $subject = 'Checkout Confirmation';
            $message = "<h1>Thank you for your purchase!</h1><p>Your checkout has been successfully recorded.</p>";

            if (sendEmail($email, $subject, $message)) {
                echo "Checkout created and email sent successfully!";
            } else {
                echo "Checkout created, but email failed to send.";
            }
        } else {
            echo "Failed to create checkout.";
        }
    }

    // Get checkout details by ID
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

    // Update checkout status
    public function updateCheckoutStatus() {
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
    public function getCheckoutsByUserId() {
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
