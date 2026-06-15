<?php
include '../auth/cek_admin.php';
include '../config/koneksi.php';

// hapus transaksi
if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    $hapus = $conn->prepare("
    DELETE FROM pesanan
    WHERE id=?
    ");

    $hapus->bind_param("i", $id);

    $hapus->execute();

    header("Location: transaksi.php");
    exit;
}

// total pemasukan
$total = $conn->query("
SELECT SUM(total_harga) as pemasukan
FROM pesanan
WHERE pembayaran='sudah_bayar'
");

$total_data = $total->fetch_assoc();

$pemasukan = $total_data['pemasukan'] ?? 0;

// ambil semua transaksi
$query = $conn->query("
SELECT 
    pesanan.id,
    users.nama,
    menu_bakso.nama_menu,
    pesanan.jumlah,
    pesanan.total_harga,
    pesanan.pembayaran,
    pesanan.status,
    pesanan.created_at
FROM pesanan
JOIN users
ON pesanan.user_id = users.id
JOIN menu_bakso
ON pesanan.menu_id = menu_bakso.id
ORDER BY pesanan.id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data Transaksi</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-100 min-h-screen p-10">

<div class="max-w-7xl mx-auto bg-white p-8 rounded-2xl shadow-lg">

    <div class="flex justify-between items-center mb-8">

        <h1 class="text-3xl font-bold text-orange-600">
            Data Transaksi
        </h1>

        <a
        href="dashboard.php"
        class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-3 rounded-xl">

            Kembali

        </a>

    </div>

    <!-- total pemasukan -->
    <div class="bg-green-100 border border-green-300 p-6 rounded-2xl mb-8">

        <h2 class="text-xl font-semibold text-green-700 mb-2">
            Total Pemasukan
        </h2>

        <h1 class="text-4xl font-bold text-green-600">
            Rp <?= number_format($pemasukan) ?>
        </h1>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full border border-gray-300">

            <tr class="bg-orange-500 text-white">

                <th class="p-3">No</th>
                <th class="p-3">Pelanggan</th>
                <th class="p-3">Menu</th>
                <th class="p-3">Jumlah</th>
                <th class="p-3">Total</th>
                <th class="p-3">Pembayaran</th>
                <th class="p-3">Status</th>
                <th class="p-3">Tanggal</th>
                <th class="p-3">Aksi</th>

            </tr>

            <?php
            $no = 1;

            while($row = $query->fetch_assoc()):
            ?>

            <tr class="border-b text-center">

                <td class="p-3">
                    <?= $no++ ?>
                </td>

                <td class="p-3">
                    <?= htmlspecialchars($row['nama']) ?>
                </td>

                <td class="p-3">
                    <?= htmlspecialchars($row['nama_menu']) ?>
                </td>

                <td class="p-3">
                    <?= $row['jumlah'] ?>x
                </td>

                <td class="p-3 font-semibold">
                    Rp <?= number_format($row['total_harga']) ?>
                </td>

                <td class="p-3">

                    <?php if($row['pembayaran'] == 'sudah_bayar'): ?>

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                            Sudah Bayar
                        </span>

                    <?php else: ?>

                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                            Belum Bayar
                        </span>

                    <?php endif; ?>

                </td>

                <td class="p-3">

                    <?php if($row['status'] == 'pending'): ?>

                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                            Pending
                        </span>

                    <?php else: ?>

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                            Selesai
                        </span>

                    <?php endif; ?>

                </td>

                <td class="p-3">
                    <?= $row['created_at'] ?>
                </td>

                <td class="p-3">

                    <a
                    href="?hapus=<?= $row['id'] ?>"
                    onclick="return confirm('Yakin ingin menghapus transaksi ini?')"
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