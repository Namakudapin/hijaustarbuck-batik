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
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn-submit">Simpan Artikel</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('addArticleForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('/../../../controllers/NewsController.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Artikel berhasil ditambahkan!');
                location.reload();
            } else {
                alert('Gagal menambahkan artikel: ' + data.message);
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });
</script>
