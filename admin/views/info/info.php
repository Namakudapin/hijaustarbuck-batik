<?php
require_once __DIR__ . '/../.././components/sidebar.php';
require_once __DIR__ . '/../../../controllers/NewsController.php';
include __DIR__ . '/addinfo.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/info/info.css">
    <link rel="stylesheet" href="/admin/assets/css/info/modalinfo.css">
    <link rel="stylesheet" href="/admin/assets/css/modal.css">
    <script>
        function showModal() {
            document.getElementById('addArticleModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('addArticleModal').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="page">
        <div class="container py-5">
            <section class="articles-section">
                <div class="articles-container">
                    <div class="articles-header">
                        <h1 class="articles-title">Artikel Terbaru</h1>
                        <button class="btn-tambah" onclick="showModal()">Tambah Artikel</button>
                    </div>
                    <div class="articles-wrapper">
                        <?php
                        $newsController = new NewsController();
                        $news = json_decode($newsController->index(), true);
                        
                        if ($news && count($news) > 0) {
                            foreach ($news as $article) {
                        ?>
                                <article class="article-card">
                                    <div class="article-image">
                                        <img src="/<?php echo htmlspecialchars($article['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($article['title']); ?>"
                                             onerror="this.src='/assets/image/bat.jpg'">
                                    </div>
                                    <div class="article-content">
                                        <h3 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h3>
                                        <p class="article-subtitle"><?php echo htmlspecialchars($article['subtitle']); ?></p>
                                        <div class="article-meta">
                                            <p class="article-date">Dipublikasikan: <?php echo date('d M Y', strtotime($article['created_at'])); ?></p>
                                        </div>
                                    </div>
                                </article>
                        <?php
                            }
                        } else {
                        ?>
                            <div class="no-articles">
                                <p>Belum ada artikel tersedia.</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
