<?php
require_once __DIR__ . '/../../components/sidebar.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    .page {
    margin-left: 250px; /* Match sidebar width */
    padding: 20px;
    background-image: url('/assets/image/3040791.jpg');
    background-size: cover;
    background-repeat: repeat;
    min-height: 100vh; /* Changed from height to min-height */
    position: relative; /* Changed from absolute */
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

    .articles-see-all {
        font-size: 0.875rem;
        color: #3182ce;
        text-decoration: none;
        display: flex;
        align-items: center;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .articles-see-all:hover {
        text-decoration: underline;
        color: #2b6cb0; 
    }

    .arrow-icon {
        margin-left: 5px;
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .articles-see-all:hover .arrow-icon {
        transform: translateX(5px);
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

<div class="page">
<div class="container py-5">

    <section class="articles-section">
        <div class="articles-container">
            <div class="articles-header">
                <h1 class="articles-title">Artikel Terbaru</h1>
            </div>

            <div class="articles-wrapper">
                <article class="article-card">
                    <div class="article-image">
                        <img src="/assets/image/bat.jpg" alt="Gambar Artikel">
                    </div>
                    <div class="article-content">
                        <h3 class="article-title">Judul Artikel</h3>
                        <p class="article-subtitle">Subjudul Artikel</p>
                        <div class="article-meta">
                            <p class="article-date">Dipublikasikan: 01 Jan 2025</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
        </div>
    </section>
</div>
