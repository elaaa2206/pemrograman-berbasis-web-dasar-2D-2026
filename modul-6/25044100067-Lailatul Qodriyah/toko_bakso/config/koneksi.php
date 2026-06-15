<?php
$conn = new mysqli("localhost", "root", "", "toko_bakso");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>