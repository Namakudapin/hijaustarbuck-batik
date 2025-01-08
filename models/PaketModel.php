<?php
//File : models/PaketModel.php

class PaketModel
{
    public function Getall()
    {
        global $conn;
        $query = "SELECT * FROM paket_domains";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    public function GetById($id)
    {
        global $conn;
        $query = "SELECT * FROM paket_domains WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }

    public function CreatePaket($title, $image, $price, $description, $size, $bandwidth, $created_at, $updated_at)
    {
        global $conn;
        $query = "INSERT INTO paket_domains (title, image, price, description, size, bandwidth, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssss", $title, $image, $price, $description, $size, $bandwidth, $created_at, $updated_at);
        return mysqli_stmt_execute($stmt);
    }

    public function UpdatePaket($id, $title, $image, $price, $description, $size, $bandwidth, $updated_at)
    {
        global $conn;
        $query = "UPDATE paket_domains SET title = ?, image = ?, price = ?, description = ?, size = ?, bandwidth = ?, updated_at = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssi", $title, $image, $price, $description, $size, $bandwidth, $updated_at, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function DeletePaket($id)
    {
        global $conn;
        $query = "DELETE FROM paket_domains WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }

}
