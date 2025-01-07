<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service List</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .page {
            margin-left: 0;
            padding: 20px;
            background-image: url('/assets/image/3040791.jpg');
            background-size: cover;
            background-repeat: repeat;
            min-height: 100vh;
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
            overflow-x: auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 24px;
            color: #333;
        }

        .add-new-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .add-new-btn:hover {
            background-color: #45a049;
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
            white-space: nowrap;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .action-btn {
            padding: 6px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            margin: 0 2px;
            display: inline-block;
        }

        .action-btn.edit {
            background-color: #2196F3;
        }

        .action-btn.delete {
            background-color: #f44336;
        }

        .action-btn:hover {
            opacity: 0.9;
        }

        .dataTables_wrapper .dataTables_paginate {
            text-align: center;
            padding-top: 15px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 4px;
            padding: 6px 12px;
            margin: 0 3px;
            background-color: #4CAF50;
            color: white !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #45a049 !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #357a38 !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 15px;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-left: 5px;
        }

        .dataTables_wrapper .dataTables_filter input {
            min-width: 200px;
        }

        .empty-message {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }

        .price-column {
            white-space: nowrap;
            font-family: 'Courier New', Courier, monospace;
        }

        .description-column {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../../components/sidebar.php'; ?>

    <div class="page">
        <div class="container">
            <div class="page-header">
                <h2 class="page-title">Data Paket Domain</h2>
                <a href="create.php" class="add-new-btn">Tambah Paket Baru</a>
            </div>

            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <table id="paketTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Harga</th>
                        <th>Kapasitas</th>
                        <th>Bandwidth</th>
                        <th>Deskripsi</th>
                        <th>Terakhir Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (isset($paket) && mysqli_num_rows($paket) > 0): 
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($paket)): 
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['title'] ?? ''); ?></td>
                            <td class="price-column">
                                Rp <?php echo number_format($row['price'] ?? 0, 0, ',', '.'); ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['size'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['bandwidth'] ?? ''); ?></td>
                            <td class="description-column" title="<?php echo htmlspecialchars($row['description'] ?? ''); ?>">
                                <?php echo htmlspecialchars($row['description'] ?? ''); ?>
                            </td>
                            <td>
                                <?php 
                                echo isset($row['updated_at']) 
                                    ? date('d/m/Y H:i', strtotime($row['updated_at'])) 
                                    : '-'; 
                                ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="action-btn edit">Edit</a>
                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)" 
                                   class="action-btn delete">Hapus</a>
                            </td>
                        </tr>
                    <?php 
                        endwhile;
                    else: 
                    ?>
                        <tr>
                            <td colspan="8" class="empty-message">Tidak ada data paket yang tersedia</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#paketTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
                "order": [[0, "asc"]],
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
                },
                "responsive": true
            });
        });

        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus paket ini?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
        document.querySelectorAll('.description-column').forEach(cell => {
            const content = cell.textContent.trim();
            if (content.length > 50) {
                cell.setAttribute('title', content);
            }
        });
    </script>
</body>
</html>