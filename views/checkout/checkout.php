<?php
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
    $checkoutController->createCheckout();
}
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
                            <strong><?php echo htmlspecialchars($paket['title']); ?></strong>
                            <div>Rp <?php echo number_format($paket['price'], 0, ',', '.'); ?></div>
                        </div>
                        <div class="transfer-card">
                            <h5 class="mb-3">Detail Transfer</h5>
                            <p>Lakukan transfer dengan nominal <strong>Rp <?php echo number_format($paket['price'], 0, ',', '.'); ?></strong> ke nomor rekening berikut:</p>
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
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?? 0; ?>">
                                <input type="hidden" name="paket_id" value="<?php echo htmlspecialchars($paket_id); ?>">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
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