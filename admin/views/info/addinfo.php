<?php
// File: index.php

require_once dirname(__DIR__) . '../../../controllers/NewsController.php';

// Handle POST request to NewsController::store
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newsController = new NewsController();
    $newsController->store();
    exit; // Stop further script execution after handling the POST
}
?>

<div id="addArticleModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Tambah Artikel</h2>
        <form id="addArticleForm" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Judul:</label>
                <input type="text" id="title" name="title" placeholder="Masukkan Judul Artikel" required>
            </div>
            <div class="form-group">
                <label for="subtitle">Subjudul:</label>
                <input type="text" id="subtitle" name="subtitle" placeholder="Masukkan Subjudul Artikel" required>
            </div>
            <div class="form-group">
                <label for="content">Konten:</label>
                <textarea id="content" name="content" placeholder="Masukkan Konten Artikel" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Gambar:</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif" required>
            </div>
            <button type="submit" class="btn-submit">Simpan Artikel</button>
        </form>
    </div>
</div>

<script>
    // Modal logic
    function showModal() {
        document.getElementById('addArticleModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('addArticleModal').style.display = 'none';
        document.getElementById('addArticleForm').reset(); // Reset form fields
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('addArticleModal');
        if (event.target === modal) {
            closeModal();
        }
    };

    // Handle form submission via AJAX
    document.getElementById('addArticleForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch('', { // Empty action will POST to the same file
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                closeModal();
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('data berhasil di upload.');
            closeModal();
            header('Location: info.php');
            exit;   
        });
    });
</script>