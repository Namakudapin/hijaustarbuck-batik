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
        include dirname(__DIR__) . '/';
    }

    public function create()
    {
        include dirname(__DIR__) . '/';
    }

    public function store()
    {
        $title = $_POST['title'];
        $image = $_POST['image'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $size = $_POST['size'];
        $bandwidth = $_POST['bandwidth'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $result = $this->paketModel->CreatePaket($title, $image, $price, $description, $size, $bandwidth, $created_at, $updated_at);

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
        $image = $_POST['image'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $size = $_POST['size'];
        $bandwidth = $_POST['bandwidth'];
        $updated_at = date('Y-m-d H:i:s');

        $result = $this->paketModel->UpdatePaket($id, $title, $image, $price, $description, $size, $bandwidth, $updated_at);

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