<?php
require_once __DIR__ . '/../.././components/sidebar.php';
require_once __DIR__ . '/../../../controllers/NewsController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/info/info.css">
    <!-- CSS untuk modal -->
    <style>
        /* Modal background */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        /* Modal content */
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        /* Close button */
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-submit {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-submit:hover {
            background-color: #45a049;
        }

        /* Button for Add Article */
        .btn-tambah {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-tambah:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        // Script untuk menampilkan modal saat tombol klik
        function showModal() {
            document.getElementById('addArticleModal').style.display = 'block';
        }

        // Script untuk menutup modal
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
                        <!-- Tombol Tambah Artikel -->
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

    <!-- Modal untuk tambah artikel -->
    <div id="addArticleModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Tambah Artikel</h2>
            <form>
                <div class="form-group">
                    <label for="title">Judul:</label>
                    <input type="text" id="title" name="title" placeholder="Masukkan Judul Artikel">
                </div>
                <div class="form-group">
                    <label for="subtitle">Subjudul:</label>
                    <input type="text" id="subtitle" name="subtitle" placeholder="Masukkan Subjudul Artikel">
                </div>
                <div class="form-group">
                    <label for="content">Konten:</label>
                    <textarea id="content" name="content" placeholder="Masukkan Konten Artikel"></textarea>
                </div>
                <button type="submit" class="btn-submit">Simpan Artikel</button>
            </form>
        </div>
    </div>
</body>
</html>
