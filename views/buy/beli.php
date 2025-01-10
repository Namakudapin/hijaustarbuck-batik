<?php
require_once __DIR__ . '/../../components/sidebar.php';
require_once __DIR__ . '/../../controllers/PaketController.php';

// Initialize the controller
$paketController = new PaketController();

// Get paket data
$paket = $paketController->index();
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
    }

    .card-link {
        text-decoration: none;
        color: inherit;
    }

    .card {
        background: linear-gradient(135deg, #85A947, #5E7D34);
        color: white;
        
        border: none;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        align-items: center;
        height: 100%;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card-title,
    .card-subtitle,
    .card-text,
    .card-link {
        font-family: 'Poppins', sans-serif;
    }

    .card-image {
        width: 100%;
        height: 150px; /* Semua gambar memiliki tinggi yang sama */
        object-fit: cover; /* Memastikan gambar tetap proporsional */
        border-radius: 10px;
        margin-bottom: 15px;
        transition: transform 0.3s ease;
    }

    .card:hover .card-image {
        transform: scale(1.05);
    }

    .price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #FFD700;
        margin: 10px 0;
    }

    .specs {
        display: flex;
        justify-content: space-between;
        margin: 15px 0;
        font-size: 0.9rem;
        color: #d0d0d0;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .card h4 {
        margin: 10px 0;
        font-size: 1.25rem;
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
        <?php if (!$paket || mysqli_num_rows($paket) == 0): ?>
            <div class="empty-state">
                <h3>No Paket Found</h3>
                <p>There are no packages available at the moment.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php while ($item = mysqli_fetch_assoc($paket)): ?>
                    <a href="/views/checkout/checkout.php?paket_id=<?php echo $item['id']; ?>" class="card-link">
                        <div class="card">
                            <?php if (!empty($item['image'])): ?>
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                     class="card-image">
                            <?php endif; ?>
                            
                            <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                            
                            <div class="price">
                                Rp <?php echo number_format($item['price'], 0, ',', '.'); ?>
                            </div>
                            
                            <p><?php echo htmlspecialchars($item['description']); ?></p>
                            
                            <div class="specs">
                                <span>
                                    <strong>Size:</strong> <?php echo htmlspecialchars($item['size']); ?>
                                </span>
                                <span>
                                    <strong>Bandwidth:</strong> <?php echo htmlspecialchars($item['bandwidth']); ?>
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</div>