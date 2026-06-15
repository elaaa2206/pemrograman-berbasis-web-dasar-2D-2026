<?php
include '../auth/cek_admin.php';
include '../config/koneksi.php';

$id = (int)$_GET['id'];

$stmt = $conn->prepare("DELETE FROM menu_bakso WHERE id=?");

$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: dashboard.php");
}
?>