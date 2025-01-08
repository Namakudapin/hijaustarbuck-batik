<?php
//File: models/CheckoutModel.php
include dirname(__DIR__) . '/services/services.php';


class CheckoutModel{

    public function createCheckout($user_id, $paket_id, $email, $created_at, $updated_at){
        global $conn;
        $query = "INSERT INTO checkouts (user_id, paket_id, email, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "iisss", $user_id, $paket_id, $email, $created_at, $updated_at);
        return mysqli_stmt_execute($stmt);
    }

    public function getCheckoutById($id){
        global $conn;
        $query = "SELECT * FROM checkouts WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }

    public function getCheckoutByUserId($user_id){
        global $conn;
        $query = "SELECT * FROM checkouts WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }

    public function getCheckoutByPaketId($paket_id){
        global $conn;
        $query = "SELECT * FROM checkouts WHERE paket_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $paket_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }

    public function updateCheckout($id, $status, $updated_at){
        global $conn;
        $query = "UPDATE checkouts SET status = ?, updated_at = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $status, $updated_at, $id);
        return mysqli_stmt_execute($stmt);
    }
    
}
?>