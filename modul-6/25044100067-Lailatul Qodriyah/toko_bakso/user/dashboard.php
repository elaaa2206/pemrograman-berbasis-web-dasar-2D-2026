<?php
include '../auth/cek_login.php';
include '../config/koneksi.php';

$data = $conn->query("SELECT * FROM menu_bakso");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2>Daftar Menu Bakso</h2>

    <a href="../auth/logout.php" class="btn btn-danger mb-3">
        Logout
    </a>

    <a href="pesanan_saya.php" class="btn btn-success mb-3">
                Pesanan Saya
    </a>

    <table class="table table-bordered">

        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jenis</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>

        <?php while($row = $data->fetch_assoc()): ?>

        <tr>

            <td><?= htmlspecialchars($row['nama_menu']) ?></td>

            <td>Rp <?= number_format($row['harga']) ?></td>

            <td><?= htmlspecialchars($row['jenis']) ?></td>

            <td><?= htmlspecialchars($row['deskripsi']) ?></td>

            <td>
                <a href="pesan.php?id=<?= $row['id'] ?>" 
                   class="btn btn-primary btn-sm">
                    Pesan
                </a>
            </td>
        
        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>