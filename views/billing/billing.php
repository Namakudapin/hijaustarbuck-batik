<?php
require_once __DIR__ . '/../../components/sidebar.php';
require_once __DIR__ . '/../../controllers/PaketUserController.php';

// Initialize the controller
$paketUserController = new PaketUserController();

// Get logged in user's ID (assuming you have this in session)
$user_id = $_SESSION['user_id'] ?? null;

// Get user's paket data using the controller's public method
$result = $paketUserController->getPaketUsersByUserId();
$paketUsers = [];

// Check if the response is JSON
$response = json_decode($result, true);
if ($response !== null) {
    $paketUsers = $response;
}
?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
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

    .card {
        margin: 10px;
        background-color: #5E686D;
        color: white;
        border: none;
        flex: 1 1 calc(33.333% - 20px);
        max-width: calc(33.333% - 20px);
        border-radius: 12px; /* Added border radius */
        padding: 20px; /* Added padding */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for better aesthetics */
    }

    .card-title,
    .card-subtitle,
    .card-text,
    .card-link {
        font-family: 'Poppins', sans-serif;
    }

    .card-link {
        color: #ffffff;
    }

    .card-link:hover {
        color: #D1D5DB;
    }

    .card-text {
        margin-bottom: 10px; /* Added spacing between text elements */
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .status-active {
        color: #4ade80;
    }

    .status-expired {
        color: #ef4444;
    }

    .empty-state {
        text-align: center;
        color: white;
        padding: 2rem;
        background-color: rgba(94, 104, 109, 0.8);
        border-radius: 8px;
        margin: 2rem auto;
        max-width: 600px;
    }
</style>


<div class="page">
    <div class="container py-5">
        <?php if (empty($paketUsers)): ?>
            <div class="empty-state">
                <h3>No Paket Found</h3>
                <p>You currently don't have any active paket subscriptions.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($paketUsers as $paket): ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo htmlspecialchars($paket['title']); ?></h4>
                            <h6 class="card-subtitle mb-2">
                                Domain: <?php echo htmlspecialchars($paket['domain']); ?>
                            </h6>
                            <p class="card-text">
                                Status: 
                                <span class="<?php echo $paket['status'] === 'active' ? 'status-active' : 'status-expired'; ?>">
                                    <?php echo ucfirst(htmlspecialchars($paket['status'])); ?>
                                </span>
                            </p>
                            <p class="card-text">
                                Expires: <?php echo date('d M Y', strtotime($paket['expired_at'])); ?>
                            </p>
                            
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>