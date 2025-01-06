    <?php
    include 'components/sidebar.php';
    ?>

    <style>
        .page {
            margin-left: 0;
            padding: 20px;
            background-image: url('assets/image/3040791.jpg');
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
            color: white;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #45a049;
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
            <h2>Data Tabel</h2>
            <table id="serviceTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Nama Domain</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Service A</td>
                        <td>servicea.com</td>
                        <td>Rp 100.000</td>
                        <td><button class="action-btn">Edit</button></td>
                    </tr>
                    <tr>
                        <td>Service B</td>
                        <td>serviceb.com</td>
                        <td>Rp 200.000</td>
                        <td><button class="action-btn">Edit</button></td>
                    </tr>
                    <tr>
                        <td>Service C</td>
                        <td>servicec.com</td>
                        <td>Rp 150.000</td>
                        <td><button class="action-btn">Edit</button></td>
                    </tr>
                    <tr>
                        <td>Service D</td>
                        <td>serviced.com</td>
                        <td>Rp 250.000</td>
                        <td><button class="action-btn">Edit</button></td>
                    </tr>
                    <tr>
                        <td>Service E</td>
                        <td>servicee.com</td>
                        <td>Rp 300.000</td>
                        <td><button class="action-btn">Edit</button></td>
                    </tr>
                    <tr>
                        <td>Service E</td>
                        <td>servicee.com</td>
                        <td>Rp 300.000</td>
                        <td><button class="action-btn">Edit</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#serviceTable').DataTable({
                "paging": true,         
                "lengthChange": true,    
                "lengthMenu": [5, 10, 15], 
                "searching": true,     
                "ordering": true,        
                "info": true,            
                "autoWidth": false    
            });
        });
    </script>
