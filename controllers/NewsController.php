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
        
        // Ensure upload directory exists
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
            return json_encode($row);
        }
        return null;
    }

    public function store()
    {
        try {
            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];
            $content = $_POST['content'];
            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            // Handle image upload
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("No image uploaded or upload error occurred.");
            }

            // Validate file type
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($file_info, $_FILES['image']['tmp_name']);
            finfo_close($file_info);

            if (!in_array($mime_type, $allowed_types)) {
                throw new Exception("Invalid file type. Only JPG, PNG, and GIF files are allowed.");
            }

            // Validate file size (max 5MB)
            $max_size = 5 * 1024 * 1024; // 5MB in bytes
            if ($_FILES['image']['size'] > $max_size) {
                throw new Exception("File is too large. Maximum size is 5MB.");
            }

            // Generate safe filename
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = 'news_' . uniqid() . '.' . $extension;
            $filepath = $this->uploadDir . $filename;

            // Move the uploaded file
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $filepath)) {
                throw new Exception("Failed to upload image. Please try again.");
            }

            // Store relative path in database
            $relative_path = '/public/uploads/image-news/' . $filename;

            // Create news record
            if ($this->newsModel->createNews($title, $subtitle, $content, $relative_path, $created_at, $updated_at)) {
                return json_encode([
                    'status' => 'success',
                    'message' => 'News created successfully!'
                ]);
            } else {
                throw new Exception("Failed to create news record.");
            }

        } catch (Exception $e) {
            // Log error for debugging
            error_log("News Creation Error: " . $e->getMessage());
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update($id)
    {
        try {
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
                    throw new Exception("Invalid file type. Only JPG, PNG, and GIF files are allowed.");
                }

                // Validate file size (max 5MB)
                $max_size = 5 * 1024 * 1024; // 5MB in bytes
                if ($_FILES['image']['size'] > $max_size) {
                    throw new Exception("File is too large. Maximum size is 5MB.");
                }

                // Generate safe filename
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = 'news_' . uniqid() . '.' . $extension;
                $filepath = $this->uploadDir . $filename;

                // Move the uploaded file
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $filepath)) {
                    throw new Exception("Failed to upload image. Please try again.");
                }

                $relative_path = '/public/uploads/image-news/' . $filename;

                // Delete old image if exists
                $old_news = $this->newsModel->getNewsById($id);
                if ($old_news && $old_row = mysqli_fetch_assoc($old_news)) {
                    $old_image_path = dirname(__DIR__) . $old_row['image'];
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }

            // Update news record
            if ($this->newsModel->updateNews($id, $title, $subtitle, $content, $relative_path, $updated_at)) {
                return json_encode([
                    'status' => 'success',
                    'message' => 'News updated successfully!'
                ]);
            } else {
                throw new Exception("Failed to update news record.");
            }

        } catch (Exception $e) {
            // Log error for debugging
            error_log("News Update Error: " . $e->getMessage());
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            // Get news details to delete image
            $news = $this->newsModel->getNewsById($id);
            if ($row = mysqli_fetch_assoc($news)) {
                $image_path = dirname(__DIR__) . $row['image'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            // Delete news record
            if ($this->newsModel->deleteNews($id)) {
                return json_encode([
                    'status' => 'success',
                    'message' => 'News deleted successfully!'
                ]);
            } else {
                throw new Exception("Failed to delete news record.");
            }

        } catch (Exception $e) {
            // Log error for debugging
            error_log("News Deletion Error: " . $e->getMessage());
            return json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}