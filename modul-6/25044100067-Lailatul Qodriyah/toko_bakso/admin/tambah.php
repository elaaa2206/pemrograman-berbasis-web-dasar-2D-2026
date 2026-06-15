<?php
include '../auth/cek_admin.php';
include '../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama = htmlspecialchars($_POST['nama']);
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $jenis = htmlspecialchars($_POST['jenis']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    $stmt = $conn->prepare("INSERT INTO menu_bakso(nama_menu,harga,stok,jenis,deskripsi)
    VALUES(?,?,?,?,?)");

    $stmt->bind_param("siiss", $nama, $harga, $stok, $jenis, $deskripsi);

    if($stmt->execute()){
        header("Location: dashboard.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card p-4">

        <h3>Tambah Menu Bakso</h3>

        <form method="POST">

            <input type="text"
            name="nama"
            class="form-control mb-3"
            placeholder="Nama Menu"
            required>

            <input type="number"
            name="harga"
            class="form-control mb-3"
            placeholder="Harga"
            required>

            <input type="number"
            name="stok"
            class="form-control mb-3"
            placeholder="Stok"
            required>

            <input type="text"
            name="jenis"
            class="form-control mb-3"
            placeholder="Jenis"
            required>

            <textarea
            name="deskripsi"
            class="form-control mb-3"
            required></textarea>

            <button type="submit"
            name="simpan"
            class="btn btn-success">
                Simpan
            </button>

        </form>

    </div>

</div>

</body>
</html>