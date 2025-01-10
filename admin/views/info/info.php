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
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
                window.location.href = 'delete.php?id=' + id;
            }
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
                        // Tambahkan fetch data menggunakan model Anda
                        $newsModel = new NewsModel();
                        $news = $newsModel->getAllNews();

                        if ($news && mysqli_num_rows($news) > 0) {
                            while ($article = mysqli_fetch_assoc($news)) {
                        ?>
                                <article class="article-card">
    <a href="detail.php?id=<?php echo urlencode($article['id']); ?>" style="text-decoration: none; color: inherit;">
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
    </a>
    <button class="btn-delete" onclick="confirmDelete(<?php echo $article['id']; ?>)">
        <img src="/admin/assets/image/trash.png" alt="Delete" style="width: 20px;">
    </button>
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
