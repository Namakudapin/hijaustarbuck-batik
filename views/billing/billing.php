<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Template</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .page {
            margin-left: 0;
            padding: 20px;
            background-image: url('/assets/image/3040791.jpg');
            background-size: cover;
            background-repeat: repeat;
            height: 100vh;
            position: absolute;
            left: 250px;
            top: 0;
            right: 0;
        }
        .card {
            margin-bottom: 20px;
            background-color: #5E686D; 
            color: white; 
            border: none; 
        }
        .card-title, .card-subtitle, .card-text, .card-link {
            font-family: 'Poppins', sans-serif;
        }
        .card-link {
            color: #ffffff; /* Warna link */
        }
        .card-link:hover {
            color: #D1D5DB; /* Warna link saat hover */
        }
    </style>
</head>
<body>
<?php
require_once __DIR__ . '/../../components/sidebar.php';
?>


    <div class="page">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4">
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
                <div class="col-md-4">
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
                <div class="col-md-4">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
