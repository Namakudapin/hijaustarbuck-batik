<?php
// File: models/PaketUserModel.php
include dirname(__DIR__) . '/services/services.php';

class PaketUserModel
{
    public function getPaketUserByUserId($user_id)
    {
        global $conn;

        // Debug: Check database connection
        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $query = "SELECT * FROM paket_users WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);

        if (!$stmt) {
            die("MySQL Prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Debug: Check for SQL errors
        if (!$result) {
            die("MySQL Error: " . mysqli_error($conn));
        }

        return $result;
    }

    public function createPaketUser($user_id, $checkout_id, $title, $domain, $status, $expired_at, $created_at, $updated_at)
    {
        global $conn;
        $query = "INSERT INTO paket_users (user_id, checkout_id, title, domain, status, expired_at, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "iissssss", $user_id, $checkout_id, $title, $domain, $status, $expired_at, $created_at, $updated_at);
        return mysqli_stmt_execute($stmt);
    }

    public function getPaketUserById($id)
    {
        global $conn;
        $query = "SELECT * FROM paket_users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }

    public function updatePaketUser($id, $status, $expired_at, $updated_at)
    {
        global $conn;
        $query = "UPDATE paket_users SET status = ?, expired_at = ?, updated_at = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $status, $expired_at, $updated_at, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function deletePaketUser($id)
    {
        global $conn;
        $query = "DELETE FROM paket_users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }

    public function isDomainExists($domain)
    {
        global $conn;
        $query = "SELECT * FROM paket_users WHERE domain = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $domain);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Return true if the domain exists
        return mysqli_num_rows($result) > 0;
    }
}
