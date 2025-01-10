<?php
session_start();

require_once __DIR__ . '/../../../controllers/NewsController.php';
$newsController = new NewsController();

if (isset($_GET['id'])) {
    $newsId = $_GET['id'];
    $newsData = json_decode($newsController->show($newsId), true);
    if (!$newsData) {
        echo "Artikel tidak ditemukan.";
        exit;
    }
} else {
    echo "Artikel tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Artikel</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Quicksand:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f7f7f7;
        }
        header {
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
        }
        .article-header h1 {
            font-family: 'Roboto', sans-serif;
            font-weight: bold;
            color: #001A45;
        }
        .article-content p {
            font-size: larger;
        }
        .article-header .text-muted {
            text-align: center;
        }
        .navbar-brand img {
            max-height: 50px;
        }
        .navbar .nav-link {
            font-weight: 600;
            color: #001A45;
        }
        .navbar .nav-link.btn-primary {
            color: #001A45;
            border-radius: 50px;
        }
        .navbar .nav-link.btn-primary:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="../home/home.php">
                    <img src="/assets/image/logo.png" alt="KelasSore Logo">
                </a>
               
                
            </div>
        </nav>
    </header>

    <!-- Main Content Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Article Header -->
                <div class="article-header mb-4 text-center">
                    <h1 class="display-4"><?php echo htmlspecialchars($newsData['title']); ?></h1>
                    <p class="text-muted">Dipublikasikan: <?php echo date('d M Y', strtotime($newsData['created_at'])); ?></p>
                </div>

                <!-- Article Image -->
                <div class="article-image mb-4">
                    <img src="<?php echo htmlspecialchars($newsData['image']); ?>" alt="Gambar Artikel" class="img-fluid w-100">
                </div>

                <!-- Article Subtitle -->
                <div class="article-subtitle mb-4">
                    <h3 class="h4"><?php echo htmlspecialchars($newsData['subtitle']); ?></h3>
                </div>

                <!-- Divider -->
                <div class="my-4 border-top"></div>

                <!-- Article Content -->
                <div class="article-content">
                    <p><?php echo nl2br(htmlspecialchars($newsData['content'])); ?></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
