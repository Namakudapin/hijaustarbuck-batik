<?php
// File: controllers/PaketController.php
include dirname(__DIR__) . '/services/services.php';
include dirname(__DIR__) . '/models/PaketModel.php';

class PaketController
{
    private $paketModel;
    private $uploadDir;

    public function __construct()
    {
        $this->paketModel = new PaketModel();
        $this->uploadDir = dirname(__DIR__) . '/public/uploads/image-paket/';
        
        // Ensure upload directory exists
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function index()
    {
        $paket = $this->paketModel->Getall();
        return $paket;
    }

    public function getPaketById($id)
    {
        $result = $this->paketModel->GetById($id);
        if ($result) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }


    public function store()
    {
        try {
            $title = $_POST['title'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $size = $_POST['size'];
            $bandwidth = $_POST['bandwidth'];
            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;
            $imagePath = null;

            // Handle image upload
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
                $max_size = 5 * 1024 * 1024;
                if ($_FILES['image']['size'] > $max_size) {
                    throw new Exception("File is too large. Maximum size is 5MB.");
                }

                // Generate safe filename
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = 'paket_' . uniqid() . '.' . $extension;
                $filepath = $this->uploadDir . $filename;

                // Move the uploaded file
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $filepath)) {
                    throw new Exception("Failed to upload image. Please try again.");
                }

                $imagePath = '/public/uploads/image-paket/' . $filename;
            }

            $result = $this->paketModel->CreatePaket($title, $imagePath, $price, $description, $size, $bandwidth, $created_at, $updated_at);

            if ($result === true) {
                header('Location: /');
                exit;
            } else {
                throw new Exception("Gagal menambahkan paket!");
            }

        } catch (Exception $e) {
            // Log error for debugging
            error_log("Paket Creation Error: " . $e->getMessage());
            die($e->getMessage());
        }

    }

    public function update($id)
    {
        try {
            $title = $_POST['title'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $size = $_POST['size'];
            $bandwidth = $_POST['bandwidth'];
            $updated_at = date('Y-m-d H:i:s');
            $imagePath = null;

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
                $max_size = 5 * 1024 * 1024;
                if ($_FILES['image']['size'] > $max_size) {
                    throw new Exception("File is too large. Maximum size is 5MB.");
                }

                // Generate safe filename
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = 'paket_' . uniqid() . '.' . $extension;
                $filepath = $this->uploadDir . $filename;

                // Move the uploaded file
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $filepath)) {
                    throw new Exception("Failed to upload image. Please try again.");
                }

                $imagePath = '/public/uploads/image-paket/' . $filename;

                // Delete old image if exists
                $old_paket = $this->paketModel->GetById($id);
                if ($old_paket && $old_row = mysqli_fetch_assoc($old_paket)) {
                    if (!empty($old_row['image'])) {
                        $old_image_path = dirname(__DIR__) . $old_row['image'];
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                }
            }

            $result = $this->paketModel->UpdatePaket($id, $title, $imagePath, $price, $description, $size, $bandwidth, $updated_at);

            if ($result === true) {
                header('Location: /');
                exit;
            } else {
                throw new Exception("Gagal mengupdate paket!");
            }

        } catch (Exception $e) {
            // Log error for debugging
            error_log("Paket Update Error: " . $e->getMessage());
            die($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Get paket details to delete image
            $paket = $this->paketModel->GetById($id);
            if ($row = mysqli_fetch_assoc($paket)) {
                if (!empty($row['image'])) {
                    $image_path = dirname(__DIR__) . $row['image'];
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
            }

            $result = $this->paketModel->DeletePaket($id);

            if ($result === true) {
                header('Location: /');
                exit;
            } else {
                throw new Exception("Gagal menghapus paket!");
            }

        } catch (Exception $e) {
            // Log error for debugging
            error_log("Paket Deletion Error: " . $e->getMessage());
            die($e->getMessage());
        }
    }
}