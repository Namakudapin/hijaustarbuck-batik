<?php
// File: views/transfer_form.php
session_start();

require_once __DIR__ . '/../../controllers/CheckoutController.php';
require_once __DIR__ . '/../../controllers/PaketController.php';

// Check if paket_id is provided
if (!isset($_GET['paket_id'])) {
    die("Paket ID tidak ditemukan.");
}

$paket_id = $_GET['paket_id'];
$paketController = new PaketController();
$checkoutController = new CheckoutController();

// Fetch paket data
$paket = $paketController->getPaketById($paket_id);
if (!$paket) {
    die("Paket tidak ditemukan.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create uploads directory if it doesn't exist
    $upload_dir = "../uploads/transfer_proofs/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Process file upload
    $file_extension = strtolower(pathinfo($_FILES["transfer_proof"]["name"], PATHINFO_EXTENSION));
    $file_name = uniqid() . "." . $file_extension;
    $upload_path = $upload_dir . $file_name;

    // Validate file type
    $allowed_types = array('jpg', 'jpeg', 'png', 'pdf');
    if (!in_array($file_extension, $allowed_types)) {
        die("Error: Invalid file type. Please upload JPG, JPEG, PNG, or PDF files only.");
    }

    if (move_uploaded_file($_FILES["transfer_proof"]["tmp_name"], $upload_path)) {
        // Set POST data for checkout
        $_POST['user_id'] = $_SESSION['user_id'] ?? 0; // Replace with actual user ID
        $_POST['paket_id'] = $paket_id;
        
        // Create checkout
        $checkoutController->createCheckout();
    } else {
        die("Error: Failed to upload file. Please try again.");
    }
}

$paket_title = htmlspecialchars($paket['title']);
$paket_price = number_format($paket['price'], 0, ',', '.');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .transfer-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
        }
        .price-box {
            background-color: #001A45;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 1.5rem;
        }
        .important-note {
            background-color: #FFF3E0;
            border-left: 4px solid #F57C00;
            padding: 15px;
            border-radius: 8px;
        }
        .btn-orange {
            background-color: #001A45;
            color: #fff;
        }
        .btn-orange:hover {
            background-color: #001A45;
            opacity: 0.9;
        }
        body {
            min-height: 100vh;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="row g-4">
                    <!-- Left Section -->
                    <div class="col-md-6">
                        <div class="price-box mb-4">
                            <strong><?php echo $paket_title; ?></strong>
                            <div>Rp <?php echo $paket_price; ?></div>
                        </div>
                        <div class="transfer-card">
                            <h5 class="mb-3">Detail Transfer</h5>
                            <p>Lakukan transfer dengan nominal <strong>Rp <?php echo $paket_price; ?></strong> ke nomor rekening berikut:</p>
                            <div class="p-3 bg-light rounded">
                                <h4 class="mb-1">0377665116</h4>
                                <p class="mb-1"><strong>BANK BCA</strong></p>
                                <p class="mb-0">a/n <strong>IT Solution</strong></p>
                            </div>
                            <div class="important-note mt-3">
                                <strong>Perhatian!</strong>
                                <p class="mb-0">Mohon pastikan nominal sesuai hingga 3 digit terakhir kode unik. Perbedaan nominal akan menghambat proses verifikasi.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="col-md-6">
                        <div class="transfer-card">
                            <h5 class="mb-3">Form Bukti Transfer</h5>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="bank" class="form-label">Bank</label>
                                    <select id="bank" name="bank" class="form-select" required>
                                        <option value="" disabled selected>Pilih Bank</option>
                                        <option value="bca">BCA</option>
                                        <option value="mandiri">Mandiri</option>
                                        <option value="bni">BNI</option>
                                        <option value="bri">BRI</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="account_number" class="form-label">Nomor Rekening</label>
                                    <input type="text" id="account_number" name="account_number" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="transfer_date" class="form-label">Tanggal Transfer</label>
                                    <input type="date" id="transfer_date" name="transfer_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="transfer_proof" class="form-label">Upload Bukti Transfer</label>
                                    <input type="file" id="transfer_proof" name="transfer_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                    <small class="text-muted">Format yang diperbolehkan: JPG, JPEG, PNG, PDF</small>
                                </div>
                                <button type="submit" class="btn btn-orange w-100">Kirim Bukti Transfer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>