<?php
    require_once __DIR__ . '/../../components/sidebar.php';
?>

<link rel="stylesheet" href="/assets/css/service/service.css">

<div class="page">
    <div class="container">
        <h2>Daftar Paket Domain</h2>
        <table id="paketTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Bandwidth</th>
                    <th>Description</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($paket)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($row['size']); ?></td>
                        <td><?php echo htmlspecialchars($row['bandwidth']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['updated_at'])); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="action-btn">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
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
</script>
