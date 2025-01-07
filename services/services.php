<?php
// File: services/database.php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "it_domain";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
