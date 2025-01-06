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
