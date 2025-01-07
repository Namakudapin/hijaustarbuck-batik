<?php 
// File: models/NewsModel.php

class NewsModel{

    public function getAllNews(){
        global $conn;
        $query = "SELECT * FROM news";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    public function getNewsById($id){
        global $conn;
        $query = "SELECT * FROM news WHERE id = $id";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    public function createNews($title, $subtitle, $content, $image, $created_at, $updated_at){
        global $conn;
        $query = "INSERT INTO news (title, subtitle, content, image, created_at, updated_at) VALUES ('$title', '$subtitle', '$content', '$image', '$created_at', '$updated_at')";
        return mysqli_query($conn, $query);
    }

    public function updateNews($id, $title, $subtitle, $content, $image, $updated_at){
        global $conn;
        $query = "UPDATE news SET title = '$title', subtitle = '$subtitle', content = '$content', image = '$image', updated_at = '$updated_at' WHERE id = $id";
        return mysqli_query($conn, $query);
    }

    public function deleteNews($id){
        global $conn;
        $query = "DELETE FROM news WHERE id = $id";
        return mysqli_query($conn, $query);
    }
}