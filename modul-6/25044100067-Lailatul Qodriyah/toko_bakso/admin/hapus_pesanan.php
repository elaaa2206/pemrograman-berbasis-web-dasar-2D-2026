<?php
include '../auth/cek_admin.php';
include '../config/koneksi.php';

$id = $_GET['id'];

$hapus = $conn->prepare("
DELETE FROM pesanan
WHERE id=?
");

$hapus->bind_param("i", $id);

$hapus->execute();

header("Location: pesanan.php");