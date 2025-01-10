<?php
// File: controllers/NewsController.php

include dirname(__DIR__) . '/models/NewsModel.php';

class NewsController
{
    private $newsModel;
    private $uploadDir;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
        $this->uploadDir = dirname(__DIR__) . '/public/uploads/image-news/';
        
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function index()
    {
        $news = $this->newsModel->getAllNews();
        $data = [];
        while ($row = mysqli_fetch_assoc($news)) {
            $data[] = $row;
        }
        return json_encode($data);
    }
    
    public function show($id)
    {
        $news = $this->newsModel->getNewsById($id);
        if ($row = mysqli_fetch_assoc($news)) {
            return json_encode($row); // Kembalikan data JSON
        } else {
            return json_encode(['status' => 'error', 'message' => 'Artikel tidak ditemukan!']);
        }
    }
    

    public function store()
    {
        try {
            header('Content-Type: application/json');

            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];
            $content = $_POST['content'];
            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            // Handle image upload
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Tidak ada gambar yang diunggah atau terjadi kesalahan.");
            }

            // Validate file type
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($file_info, $_FILES['image']['tmp_name']);
            finfo_close($file_info);

            if (!in_array($mime_type, $allowed_types)) {
                throw new Exception("Tipe file tidak valid. Hanya file JPG, PNG, dan GIF yang diperbolehkan.");
            }

            // Validate file size (max 5MB)
            $max_size = 5 * 1024 * 1024;
            if ($_FILES['image']['size'] > $max_size) {
                throw new Exception("Ukuran file terlalu besar. Maksimum 5MB.");
            }

            // Generate safe filename
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = 'news_' . uniqid() . '.' . $extension;
            $filepath = $this->uploadDir . $filename;

            // Move the uploaded file
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $filepath)) {
                throw new Exception("Gagal mengunggah gambar. Silakan coba lagi.");
            }

            $relative_path = '/public/uploads/image-news/' . $filename;

            if ($this->newsModel->createNews($title, $subtitle, $content, $relative_path, $created_at, $updated_at)) {
                echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil ditambahkan!']);
            } else {
                throw new Exception("Gagal menambahkan artikel.");
            }

        } catch (Exception $e) {
            error_log("News Creation Error: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update($id)
    {
        try {
            header('Content-Type: application/json');

            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];
            $content = $_POST['content'];
            $updated_at = date('Y-m-d H:i:s');
            $relative_path = null;

            // Handle image upload if provided
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Validate file type
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                $file_info = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($file_info, $_FILES['image']['tmp_name']);
                finfo_close($file_info);

                if (!in_array($mime_type, $allowed_types)) {
                    throw new Exception("Tipe file tidak valid. Hanya file JPG, PNG, dan GIF yang diperbolehkan.");
                }

                // Validate file size
                $max_size = 5 * 1024 * 1024;
                if ($_FILES['image']['size'] > $max_size) {
                    throw new Exception("Ukuran file terlalu besar. Maksimum 5MB.");
                }

                // Generate safe filename
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = 'news_' . uniqid() . '.' . $extension;
                $filepath = $this->uploadDir . $filename;

                // Move the uploaded file
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $filepath)) {
                    throw new Exception("Gagal mengunggah gambar. Silakan coba lagi.");
                }

                $relative_path = '/public/uploads/image-news/' . $filename;

                // Delete old image if exists
                $old_news = $this->newsModel->getNewsById($id);
                if ($old_news && $old_row = mysqli_fetch_assoc($old_news)) {
                    if (!empty($old_row['image'])) {
                        $old_image_path = dirname(__DIR__) . $old_row['image'];
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                }
            }

            if ($this->newsModel->updateNews($id, $title, $subtitle, $content, $relative_path, $updated_at)) {
                echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil diperbarui!']);
            } else {
                throw new Exception("Gagal memperbarui artikel.");
            }

        } catch (Exception $e) {
            error_log("News Update Error: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            // Get news details to delete image
            $news = $this->newsModel->getNewsById($id);
            if ($row = mysqli_fetch_assoc($news)) {
                if (!empty($row['image'])) {
                    $image_path = dirname(__DIR__) . $row['image'];
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
            }

            if ($this->newsModel->deleteNews($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil dihapus!']);
            } else {
                throw new Exception("Gagal menghapus artikel.");
            }

        } catch (Exception $e) {
            error_log("News Deletion Error: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}