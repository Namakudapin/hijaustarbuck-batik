<?php 
require_once __DIR__ . '/../.././components/sidebar.php';
require_once __DIR__ . '/../../../controllers/PaketController.php';

// Ambil ID dari URL
$paketId = $_GET['id'] ?? null;
if (!$paketId) {
    die('ID paket tidak ditemukan.');
}

$paketController = new PaketController();
$paketData = $paketController->getPaketById($paketId);

if (!$paketData) {
    die('Paket tidak ditemukan.');
}
?>

<link rel="stylesheet" href="/admin/assets/css/dashboard/dashboard.css">

<div class="page">
    <div class="container">
        <h2>Edit Paket Domain</h2>
        <form id="editPackageForm" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($paketId); ?>">

            <div>
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($paketData['title']); ?>" required>
            </div>
           
            <div>
                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($paketData['price']); ?>" required>
            </div>
            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($paketData['description']); ?></textarea>
            </div>
            <div>
                <label for="bandwidth">Bandwidth</label>
                <input type="text" id="bandwidth" name="bandwidth" value="<?php echo htmlspecialchars($paketData['bandwidth']); ?>" required>
            </div>
            <button type="submit" class="action-btn">Simpan Perubahan</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#editPackageForm').on('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(this);
        formData.append('updated_at', new Date().toISOString().slice(0, 19).replace('T', ' '));

        $.ajax({
            url: '/admin/views/service/process_edit_paket.php', 
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                try {
                    const result = JSON.parse(response);
                    if (result.success) {
                        alert('Paket berhasil diperbarui!');
                        window.location.href = '/admin/views/service/service.php';
                    } else {
                        alert('Gagal memperbarui paket!');
                    }
                } catch (e) {
                    alert('Paket berhasil diperbarui.');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.status);
                console.log(status);
                console.log(error);
                alert('Gagal memperbarui paket! Silakan coba lagi.');
            }
        });
    });
});
</script>

<style>
    .container {
        width: 80%;
        margin: 0 auto;
        padding: 30px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .container form div {
        margin-bottom: 20px;
    }

    .container form div label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .container form div input,
    .container form div select,
    .container form div textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .container form div textarea {
        resize: vertical;
    }

    .action-btn {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .action-btn:hover {
        background-color: #45a049;
    }
</style>
