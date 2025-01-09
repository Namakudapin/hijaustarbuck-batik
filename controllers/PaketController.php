<?php 
// File: controllers/PaketController.php
include dirname(__DIR__) . '/services/services.php';
include dirname(__DIR__) . '/models/PaketModel.php';

class PaketController
{
    private $paketModel;

    public function __construct()
    {
        $this->paketModel = new PaketModel();
    }

    public function index()
    {
        $paket = $this->paketModel->Getall();
        return $paket;
    }

    public function create()
    {
        include dirname(__DIR__) . '/';
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
        $title = $_POST['title'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $size = $_POST['size'];
        $bandwidth = $_POST['bandwidth'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // Handle image upload (optional)
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = './public/uploads/';
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = 'public/uploads/' . $fileName;
            } else {
                echo "Failed to upload image.";
                return;
            }
        }

        $result = $this->paketModel->CreatePaket($title, $imagePath, $price, $description, $size, $bandwidth, $created_at, $updated_at);

        if ($result === true) {
            header('Location: /');
        } else {
            echo "Gagal menambahkan paket!";
        }
    }

    public function edit($id)
    {
        $paket = $this->paketModel->GetById($id);
        include dirname(__DIR__) . '/';
    }

    public function update($id)
    {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $size = $_POST['size'];
        $bandwidth = $_POST['bandwidth'];
        $updated_at = date('Y-m-d H:i:s');

         // Handle image upload (optional)
         if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = './public/uploads/';
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = 'public/uploads/' . $fileName;
            } else {
                echo "Failed to upload image.";
                return;
            }
        }

        $result = $this->paketModel->UpdatePaket($id, $title, $imagePath, $price, $description, $size, $bandwidth, $updated_at);

        if ($result === true) {
            header('Location: /');
        } else {
            echo "Gagal mengupdate paket!";
        }
    }

    public function delete($id)
    {
        $result = $this->paketModel->DeletePaket($id);

        if ($result === true) {
            header('Location: /');
        } else {
            echo "Gagal menghapus paket!";
        }
    }
}