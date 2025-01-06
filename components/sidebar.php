<style>
    .sidebar {
        width: 250px;
        background-color: #036635; /* Hijau Starbucks */
        color: white;
        height: 100vh;
        padding: 20px;
        box-sizing: border-box;
        position: fixed;
        top: 0;
        left: 0;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
    }

    .sidebar ul li {
        margin: 15px 0;
    }

    .sidebar ul li a {
        color: white;
        text-decoration: none;
        font-size: 16px;
    }

    .sidebar ul li a:hover {
        text-decoration: underline;
    }
</style>

<div class="sidebar">
    <h2>Menu</h2>
    <ul>
        <li><a href="/views/service/service.php">Service</a></li>
        <li><a href="/views/billing/billing.php">Billing</a></li>
        <li><a href="/views/info/info.php">Info</a></li>
        <li><a href="#">Upgrade</a></li>
    </ul>
</div>

