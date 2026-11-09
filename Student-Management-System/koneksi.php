<?php
$servername = "localhost";
$user = "root";
$password = "";
$db = "crud";

$conn = mysqli_connect($servername, $user, $password, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
// mysqli_select_db($conn, $db); // tidak perlu, sudah dipilih saat koneksi
