<?php
require_once __DIR__ . '/../../components/sidebar.php';
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
        flex: 1 1 calc(33.333% - 20px); /* Membagi 3 bagian */
        max-width: calc(33.333% - 20px);
    }

    .card-title, .card-subtitle, .card-text, .card-link {
        font-family: 'Poppins', sans-serif;
    }

    .card-link {
        color: #ffffff;
    }

    .card-link:hover {
        color: #D1D5DB;
    }

    .row {
        display: flex;
        flex-wrap: nowrap; /* Tidak akan pindah ke baris baru */
        justify-content: space-between;
    }
</style>

<div class="page">
    <div class="container py-5">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Card title</h4>
                    <h6 class="card-subtitle text-muted">Support card subtitle</h6>
                    <p class="card-text">Some quick example text to build on the card title.</p>
                    <a href="#" class="card-link">Link</a>
                    <a href="#" class="card-link">Second link</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Card title</h4>
                    <h6 class="card-subtitle text-muted">Support card subtitle</h6>
                    <p class="card-text">Some quick example text to build on the card title.</p>
                    <a href="#" class="card-link">Link</a>
                    <a href="#" class="card-link">Second link</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Card title</h4>
                    <h6 class="card-subtitle text-muted">Support card subtitle</h6>
                    <p class="card-text">Some quick example text to build on the card title.</p>
                    <a href="#" class="card-link">Link</a>
                    <a href="#" class="card-link">Second link</a>
                </div>
            </div>
        </div>
    </div>
</div>
