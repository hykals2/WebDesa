<?php
$host = "localhost";
$user = "root"; // User default di XAMPP
$pass = "";     // Password default di XAMPP
$db   = "desa_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>