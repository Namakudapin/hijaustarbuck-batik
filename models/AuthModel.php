<?php
// File: models/AuthModel.php

class AuthModel {

    public function getUserByEmail($email) {
        global $conn;
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function createUser($email, $username, $password) {
        global $conn;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $created_at = date("Y-m-d H:i:s");
        $updated_at = $created_at;
        
        $query = "INSERT INTO users (email, username, password , created_at, updated_at) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt, "sssss", $email, $username, $hashedPassword, $created_at, $updated_at);
        
        return mysqli_stmt_execute($stmt);
    }

    public function loginUser($email, $password) {
        $result = $this->getUserByEmail($email);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                return $user; 
            }
        }
        return false;
    }

    public function registerUser($email, $username, $password, $password_confirm)
    {
        if (empty($email) || empty($username) || empty($password) || empty($password_confirm)) {
            return "Semua field harus diisi!";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Format email tidak valid!";
        }

        if (strlen($password) < 6) {
            return "Password minimal 6 karakter!";
        }

        if ($password !== $password_confirm) {
            return "Password dan konfirmasi password tidak cocok!";
        }

        $result = $this->getUserByEmail($email);
        if ($result->num_rows > 0) {
            return "Email sudah terdaftar!";
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if ($this->createUser($email, $username, $hashedPassword)) {
            return true;
        } else {
            return "Terjadi kesalahan saat pendaftaran!";
        }
    }
}
?>