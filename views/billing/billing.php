<?php
session_start(); // Add this at the very top of the file
require_once __DIR__ . '/../../components/sidebar.php';
require_once __DIR__ . '/../../controllers/CheckoutController.php';
$checkoutController = new CheckoutController();

// Debug information
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    error_log("No user_id found in session");
}

$paketUsers = [];
if ($user_id) {
    $_GET['user_id'] = $user_id;
    ob_start();
    $checkoutController->getCheckoutsByUserId($user_id);
    $response = ob_get_clean();
    
    // Debug response
    error_log("API Response: " . $response);
    
    $paketUsers = json_decode($response, true) ?? [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Grid</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .page {
            margin-left: 250px;
            padding: 20px;
            background-image: url('/assets/image/3040791.jpg');
            background-size: cover;
            background-repeat: repeat;
            min-height: 100vh;
            position: relative;
            top: 0;
            right: 0;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .card {
            background-color: #5E686D;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }

        .card-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #ffffff;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 500;
            color: #D1D5DB;
            font-size: 0.9rem;
        }

        .info-value {
            text-align: right;
            font-weight: 400;
        }

        .empty-state {
            text-align: center;
            color: white;
            padding: 3rem;
            background-color: rgba(94, 104, 109, 0.8);
            border-radius: 12px;
            margin: 2rem auto;
            max-width: 600px;
            grid-column: 1 / -1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .empty-state h3 {
            margin: 0 0 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .empty-state p {
            margin: 0;
            color: #D1D5DB;
        }

        .status-active {
            color: #4ade80;
            font-weight: 500;
        }

        .status-expired {
            color: #ef4444;
            font-weight: 500;
        }

        .status-pending {
            color: #fbbf24;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .page {
                margin-left: 0;
            }

            .container {
                grid-template-columns: 1fr;
                padding: 10px;
            }

            .card {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="container">
            <?php if (empty($paketUsers)): ?>
                <div class="empty-state">
                    <h3>No Active Subscriptions</h3>
                    <p>You currently don't have any active package subscriptions.</p>
                </div>
            <?php else: ?>
                <?php foreach ($paketUsers as $paket): ?>
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title"><?php echo htmlspecialchars($paket['paket_name'] ?? 'Package Name'); ?></h3>
                        </div>
                        <div class="card-content">
                            <div class="info-item">
                                <span class="info-label">Status</span>
                                <span class="status-badge status-<?php echo strtolower($paket['status'] ?? 'pending'); ?>">
                                    <?php echo ucfirst(htmlspecialchars($paket['status'] ?? 'Pending')); ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Expired Date</span>
                                <span class="info-value">
                                    <?php echo date('d M Y', strtotime($paket['expired_at'])); ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Purchase Date</span>
                                <span class="info-value">
                                    <?php echo date('d M Y', strtotime($paket['created_at'])); ?>
                                </span>
                            </div>
                            <?php if (isset($paket['expired_at'])): ?>
                            <div class="info-item">
                                <span class="info-label">Expiry Date</span>
                                <span class="info-value">
                                    <?php echo date('d M Y', strtotime($paket['expired_at'])); ?>
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php if (isset($paket['transfer_proof'])): ?>
                            <div class="info-item">
                                <span class="info-label">Payment Proof</span>
                                <a href="<?php echo htmlspecialchars($paket['transfer_proof']); ?>" 
                                   target="_blank" 
                                   class="info-value" 
                                   style="color: #4ADE80; text-decoration: none;">
                                    View Document
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>