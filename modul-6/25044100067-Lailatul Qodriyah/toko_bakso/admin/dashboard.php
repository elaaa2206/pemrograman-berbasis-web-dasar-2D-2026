<?php
include '../auth/cek_admin.php';
include '../config/koneksi.php';

$data = $conn->query("
SELECT * FROM menu_bakso
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Admin</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-100 min-h-screen p-10">

<div class="max-w-7xl mx-auto bg-white p-8 rounded-3xl shadow-xl">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-4xl font-bold text-orange-600">
                Dashboard Admin
            </h1>

            <p class="text-gray-500 mt-2">
                Kelola menu dan transaksi toko bakso
            </p>

        </div>

        <a
        href="../auth/logout.php"
        class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-2xl">

            Logout

        </a>

    </div>

    <!-- MENU ADMIN -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-10">

        <a
        href="tambah.php"
        class="bg-orange-500 hover:bg-orange-600 text-white p-6 rounded-2xl shadow-lg text-center">

            <p class="font-semibold">
                Tambah Menu
            </p>

        </a>

        <a
        href="pesanan.php"
        class="bg-yellow-500 hover:bg-yellow-600 text-white p-6 rounded-2xl shadow-lg text-center">

            <p class="font-semibold">
                Data Pesanan
            </p>

        </a>

        <a
        href="transaksi.php"
        class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-2xl shadow-lg text-center">

            <h2 class="text-2xl font-bold mb-2">
                
            </h2>

            <p class="font-semibold">
                Transaksi
            </p>

        </a>

        <a
        href="../auth/logout.php"
        class="bg-red-500 hover:bg-red-600 text-white p-6 rounded-2xl shadow-lg text-center">

            <p class="font-semibold">
                Logout
            </p>

        </a>

    </div>

    <!-- TABEL MENU -->
    <div class="overflow-x-auto">

        <table class="w-full border border-gray-300">

            <tr class="bg-orange-500 text-white">

                <th class="p-3">No</th>
                <th class="p-3">Nama Menu</th>
                <th class="p-3">Harga</th>
                <th class="p-3">Stok</th>
                <th class="p-3">Jenis</th>
                <th class="p-3">Deskripsi</th>
                <th class="p-3">Aksi</th>

            </tr>

            <?php
            $no = 1;

            while($row = $data->fetch_assoc()): #fetch_asoc untuk mengambil data hasil query dari database dalam bentuk array associative.
            #htmlspecialchars untuk menampilkan data menjadi teks, jadi tulisannya itu tidak jadi perintah tapi jadi tulisan biasa
            ?>

            <tr class="border-b text-center">

                <td class="p-3">
                    <?= $no++ ?>
                </td>

                <td class="p-3 font-semibold">
                    <?= htmlspecialchars($row['nama_menu']) ?>
                </td>

                <td class="p-3">
                    Rp <?= number_format($row['harga']) ?>
                </td>

                <td class="p-3">
                    <?= $row['stok'] ?>
                </td>

                <td class="p-3">
                    <?= htmlspecialchars($row['jenis']) ?>
                </td>

                <td class="p-3">
                    <?= htmlspecialchars($row['deskripsi']) ?>
                </td>

                <td class="p-3 space-x-2">

                    <a
                    href="edit.php?id=<?= $row['id'] ?>"
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-xl text-sm">

                        Edit

                    </a>

                    <a
                    href="hapus.php?id=<?= $row['id'] ?>"
                    onclick="return confirm('Yakin ingin menghapus menu ini?')"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm">

                        Hapus

                    </a>

                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>