<?php
include '../auth/cek_admin.php';
include '../config/koneksi.php';

$id = (int)$_GET['id'];

//mencari menu berdasarkan id dana stmt adalah untuk menyimpan query yang diperolleh dari prepare
$stmt = $conn->prepare("SELECT * FROM menu_bakso WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

//get result untuk mengabil queryr dan fect assoc sebagai mengambir satu  bari data
$data = $stmt->get_result()->fetch_assoc();

if(isset($_POST['update'])){

    $nama = htmlspecialchars($_POST['nama']);
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $jenis = htmlspecialchars($_POST['jenis']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    $update = $conn->prepare("UPDATE menu_bakso
    SET nama_menu=?, harga=?, stok=?, jenis=?, deskripsi=?
    WHERE id=?");
//memasukkan data ke tanda ? pada query SQL, siissi itu adalah sstring integer 
    $update->bind_param("siissi",
    $nama,
    $harga,
    $stok,
    $jenis,
    $deskripsi,
    $id);

    if($update->execute()){
        header("Location: dashboard.php");
    }
}
?>