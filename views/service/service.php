<?php
require_once __DIR__ . '/../../components/sidebar.php';
require_once __DIR__ . '/../../controllers/PaketUserController.php';

$controller = new PaketUserController();
$paketUsers = json_decode($controller->getPaketUsersByUserId(), true);
?>

<style>
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
        background-color: rgba(255, 255, 255, 0.1);
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        margin-top: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    .action-btn {
        padding: 5px 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .action-btn:hover {
        background-color: #45a049;
    }

    .dataTables_wrapper .dataTables_paginate {
        text-align: center;
        padding-top: 10px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 5px;
        padding: 5px 10px;
        margin: 0 3px;
        background-color: #4CAF50;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #45a049 !important;
        border: 1px solid #45a049;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 15px;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        padding: 5px;
        margin-left: 10px;
    }
</style>

<div class="page">
    <div class="container">
        <h2>Daftar Paket Domain</h2>
        <table id="paketTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Domain</th>
                    <th>Status</th>
                    <th>Expired At</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paketUsers as $paket) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($paket['title']); ?></td>
                        <td><?php echo htmlspecialchars($paket['domain']); ?></td>
                        <td><?php echo htmlspecialchars($paket['status']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($paket['expired_at'])); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($paket['updated_at'])); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $paket['id']; ?>" class="action-btn">Edit</a>
                            <button onclick="deletePaket(<?php echo $paket['id']; ?>)" class="action-btn">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
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