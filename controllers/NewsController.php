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

    public function store()
    {
        header('Content-Type: application/json');
    
        // Validate inputs
        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;
    
        if (empty($title) || empty($subtitle) || empty($content)) {
            echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi.']);
            return;
        }
    
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = __DIR__ . '/../../public/image-news/';
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;
    
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                echo json_encode(['status' => 'error', 'message' => 'Format file tidak valid.']);
                return;
            }
    
            // Move uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = 'public/image-news/' . $fileName;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mengunggah gambar.']);
                return;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada gambar yang diunggah.']);
            return;
        }
    
        // Save news data
        if ($this->newsModel->createNews($title, $subtitle, $content, $imagePath, $created_at, $updated_at)) {
            echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil ditambahkan!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan artikel.']);
        }
    }
    

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
