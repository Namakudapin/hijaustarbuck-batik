<?php
require_once __DIR__ . '/../../components/sidebar.php';
require_once __DIR__ . '/../../controllers/NewsController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

        .articles-section {
            padding: 2rem;
            position: relative;
            border-radius: 8px;
            margin-top: 20px;
        }

        .articles-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .articles-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .articles-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }

        .articles-wrapper {
            display: flex;
            gap: 1rem;
            overflow: hidden;
            position: relative;
            scroll-behavior: smooth;
            flex-wrap: wrap;
        }

        .article-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s ease-in-out;
            flex: 0 0 calc(25% - 1rem);
            max-width: calc(25% - 1rem);
        }

        .article-card:hover {
            transform: translateY(-5px);
        }

        .article-image img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            display: block;
        }

        .article-content {
            padding: 1rem;
        }

        .article-title {
            color: #2d3748;
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
            line-height: 1.4;
        }

        .article-subtitle {
            color: #718096;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .article-meta {
            color: #2d3748;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }
        

        .no-articles {
            width: 100%;
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 0.5rem;
            color: #718096;
        }

        @media (max-width: 768px) {
            .articles-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .article-card {
                flex: 0 0 calc(50% - 1rem);
                max-width: calc(50% - 1rem);
            }
        }

        @media (max-width: 480px) {
            .article-card {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .article-content {
                padding: 0.5rem;
            }

            .article-title {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="container py-5">
            <section class="articles-section">
                <div class="articles-container">
                    <div class="articles-header">
                        <h1 class="articles-title">Artikel Terbaru</h1>
                    </div>

                    <div class="articles-wrapper">
                        <?php
                        $newsController = new NewsController();
                        $news = json_decode($newsController->index(), true);
                        
                        if ($news && count($news) > 0) {
                            foreach ($news as $article) {
                        ?>
                        <article class="article-card">
    <a href="detaill.php?id=<?php echo urlencode($article['id']); ?>" style="text-decoration: none; color: inherit;">
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