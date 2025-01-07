<?php
// File: controllers/NewsController.php

include dirname(__DIR__) . '/models/NewsModel.php';

class NewsController
{
    private $newsModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
    }

    // Get all news
    public function index()
    {
        $news = $this->newsModel->getAllNews();
        $data = [];
        while ($row = mysqli_fetch_assoc($news)) {
            $data[] = $row;
        }
        return json_encode($data); // Return the JSON-encoded string
    }
    
    // Get news by ID
    public function show($id)
    {
        $news = $this->newsModel->getNewsById($id);
        if ($row = mysqli_fetch_assoc($news)) {
            echo json_encode($row);
        } else {
            echo "News not found!";
        }
    }

    // Create a new news
    public function store()
    {
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $content = $_POST['content'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = './public/image-news/';
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = 'public/image-news/' . $fileName;
            } else {
                echo "Failed to upload image.";
                return;
            }
        } else {
            echo "No image uploaded.";
            return;
        }

        if ($this->newsModel->createNews($title, $subtitle, $content, $imagePath, $created_at, $updated_at)) {
            echo "News created successfully!";
        } else {
            echo "Failed to create news.";
        }
    }

    // Update an existing news
    public function update($id)
    {
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $content = $_POST['content'];
        $updated_at = date('Y-m-d H:i:s');
        $imagePath = null;

        // Handle image upload (optional)
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = './public/image-news/';
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = 'public/image-news/' . $fileName;
            } else {
                echo "Failed to upload image.";
                return;
            }
        }

        if ($this->newsModel->updateNews($id, $title, $subtitle, $content, $imagePath, $updated_at)) {
            echo "News updated successfully!";
        } else {
            echo "Failed to update news.";
        }
    }

    // Delete a news
    public function destroy($id)
    {
        if ($this->newsModel->deleteNews($id)) {
            echo "News deleted successfully!";
        } else {
            echo "Failed to delete news.";
        }
    }
}
?>
