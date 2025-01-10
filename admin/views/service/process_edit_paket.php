<?php
require_once __DIR__ . '/../../../controllers/PaketController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paketController = new PaketController();

    $id = $_POST['id'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $bandwidth = $_POST['bandwidth'];
    $updated_at = $_POST['updated_at'];

    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imagePath = '/public/uploads/image-paket/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], dirname(__DIR__, 3) . $imagePath);
    }

    $result = $paketController->update($id, $title, $price, $description, $size, $bandwidth, $imagePath, $updated_at);

    echo json_encode(['success' => $result]);
}
