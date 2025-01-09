<?php

include_once '/../../../controllers/PaketController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new PaketController();

    // Handle file upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';  // Pastikan direktori ini ada dan dapat ditulis
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $fileName;

        // Validasi file (misalnya hanya menerima gambar)
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileMimeType = mime_content_type($_FILES['image']['tmp_name']);

        if (in_array($fileMimeType, $allowedMimeTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image = $targetPath;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Hanya file gambar yang diizinkan.']);
            exit;
        }
    }

    // Pastikan data lainnya diteruskan ke controller
    $title = $_POST['title'] ?? '';
    $price = $_POST['price'] ?? '';
    $description = $_POST['description'] ?? '';
    $size = $_POST['size'] ?? '';
    $bandwidth = $_POST['bandwidth'] ?? '';
    
    // Gabungkan semua data termasuk image ke dalam array POST untuk diproses
    $formData = [
        'title' => $title,
        'price' => $price,
        'description' => $description,
        'size' => $size,
        'bandwidth' => $bandwidth,
        'image' => $image,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    // Pass the form data to the controller
    $controller->store($formData);

    // Return JSON response
    echo json_encode(['success' => true, 'message' => 'Paket berhasil ditambahkan!']);
    exit;
}
