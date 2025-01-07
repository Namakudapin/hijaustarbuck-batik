<?php
// File: models/AuthModel.php

class AuthModel {
    public function getUserByEmail($email) {
        global $conn;
        try {
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = mysqli_prepare($conn, $query);
            
            if (!$stmt) {
                throw new Exception("Database prepare failed: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($stmt, "s", $email);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Database execute failed: " . mysqli_stmt_error($stmt));
            }
            
            $result = mysqli_stmt_get_result($stmt);
            return $result;
        } catch (Exception $e) {
            error_log("Error in getUserByEmail: " . $e->getMessage());
            return false;
        }
    }

    public function createUser($email, $username, $password) {
        global $conn;
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $created_at = date("Y-m-d H:i:s");
            $updated_at = $created_at;
            
            $query = "INSERT INTO users (email, username, password, created_at, updated_at) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            
            if (!$stmt) {
                throw new Exception("Database prepare failed: " . mysqli_error($conn));
            }
            
            mysqli_stmt_bind_param($stmt, "sssss", $email, $username, $hashedPassword, $created_at, $updated_at);
            
            return mysqli_stmt_execute($stmt);
        } catch (Exception $e) {
            error_log("Error in createUser: " . $e->getMessage());
            return false;
        }
    }

    public function loginUser($email, $password) {
        try {
            $result = $this->getUserByEmail($email);
            
            // Check if getUserByEmail returned false (error occurred)
            if ($result === false) {
                error_log("Error getting user by email");
                return false;
            }
            
            // Check if user exists
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Remove sensitive data before returning
                    unset($user['password']);
                    return $user;
                } else {
                    error_log("Invalid password for user: " . $email);
                }
            } else {
                error_log("User not found: " . $email);
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Error in loginUser: " . $e->getMessage());
            return false;
        }
    }

    public function registerUser($email, $username, $password, $password_confirm) {
        try {
            // Validation
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

            // Check if email exists
            $result = $this->getUserByEmail($email);
            if ($result === false) {
                return "Terjadi kesalahan saat memeriksa email!";
            }
            
            if (mysqli_num_rows($result) > 0) {
                return "Email sudah terdaftar!";
            }

            // Create user
            if ($this->createUser($email, $username, $password)) {
                return true;
            }
            
            return "Terjadi kesalahan saat pendaftaran!";
        } catch (Exception $e) {
            error_log("Error in registerUser: " . $e->getMessage());
            return "Terjadi kesalahan sistem!";
        }
    }
}
?>