<?php 
require_once __DIR__ . '/../.././components/sidebar.php';
require_once __DIR__ . '/../../../controllers/PaketController.php';

$paketController = new PaketController();
$paketUsers = $paketController->index(); // Fetch semua paket dari controller
?>

<link rel="stylesheet" href="/admin/assets/css/dashboard/dashboard.css">

<div class="page">
    <div class="container">
        <h2>Daftar Paket Domain</h2>
        <!-- Link to navigate to addservice.php -->
        <button class="action-btn" id="addPackageBtn" onclick="window.location.href='/admin/views/service/addservice.php';">Buat Paket</button>
        
        <table id="paketTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>price</th>
                    <th>description</th>
                    <th>bandwidth</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php if ($paketUsers && mysqli_num_rows($paketUsers) > 0) : ?>
        <?php while ($paket = mysqli_fetch_assoc($paketUsers)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($paket['title'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($paket['price'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($paket['description'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($paket['bandwidth'] ?? 'N/A'); ?></td>
                <td><?php echo !empty($paket['updated_at']) ? date('d/m/Y H:i', strtotime($paket['updated_at'])) : 'N/A'; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $paket['id']; ?>" class="action-btn">Edit</a>
                    <button onclick="deletePaket(<?php echo $paket['id']; ?>)" class="action-btn">Delete</button>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else : ?>
        <tr>
            <td colspan="6">Tidak ada data paket tersedia.</td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script>
    $(document).ready(function() {
        $('#paketTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "lengthMenu": [5, 10, 15],
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });

    function deletePaket(id) {
        if (confirm('Are you sure you want to delete this package?')) {
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    alert('Package deleted successfully!');
                    location.reload();
                },
                error: function() {
                    alert('Failed to delete package!');
                }
            });
        }
    }
</script>
