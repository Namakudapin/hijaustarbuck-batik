<?php 

require_once __DIR__ . '/../.././components/sidebar.php';
session_start();  // Start the session to access session variables

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: /admin/views/login/login.php');
    exit();  // Ensure no further code is executed
}
?>

<link rel="stylesheet" href="/admin/assets/css/dashboard/dashboard.css">

<div class="page">
    <div class="stats">
        <div class="stat-item">
            <h3>Total Users</h3>
            <p id="totalUsers">0</p>
        </div>
        <div class="stat-item">
            <h3>Total Services</h3>
            <p id="totalServices">0</p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch stats data
        $.ajax({
            url: '/path/to/stats/api',
            type: 'GET',
            success: function(response) {
                // Assuming response contains { totalUsers: X, totalServices: Y }
                $('#totalUsers').text(response.totalUsers);
                $('#totalServices').text(response.totalServices);
            },
            error: function() {
                alert('Failed to load statistics data.');
            }
        });
    });
</script>

<style>
    .stats {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
    }

    .stat-item {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        width: 45%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stat-item h3 {
        margin-bottom: 10px;
        font-size: 1.5em;
    }

    .stat-item p {
        font-size: 2em;
        color: #333;
        margin: 0;
    }
</style>