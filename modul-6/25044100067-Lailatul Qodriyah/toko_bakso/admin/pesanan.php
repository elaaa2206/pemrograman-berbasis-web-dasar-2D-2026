<?php
include '../auth/cek_admin.php';
include '../config/koneksi.php';

// ubah status selesai
if(isset($_GET['selesai'])){

    $id = $_GET['selesai'];

    $update = $conn->prepare("
    UPDATE pesanan
    SET status='selesai'
    WHERE id=?
    ");

    $update->bind_param("i", $id);

    $update->execute();

    header("Location: pesanan.php");
    exit;
}

// ambil data pesanan
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

<title>Data Pesanan</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-100 min-h-screen p-10">

<div class="max-w-7xl mx-auto bg-white p-8 rounded-2xl shadow-lg">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">

        <h1 class="text-3xl font-bold text-orange-600">
            Data Pesanan Pelanggan
        </h1>

        <a
        href="dashboard.php"
        class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-3 rounded-xl">

            Kembali

        </a>

    </div>

    <!-- tombol tambah -->
    <div class="mb-6">

        <a
        href="tambah_pesanan.php"
        class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-3 rounded-xl">

            Tambah Pesanan

        </a>

    </div>

    <!-- tabel -->
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

                <!-- pembayaran -->
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

                <!-- status -->
                <td class="p-3">

                    <?php if($row['status'] == 'pending'): ?>

                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                            Diproses
                        </span>

                    <?php else: ?>

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                            Selesai
                        </span>

                    <?php endif; ?>

                </td>

                <!-- tanggal dan waktu -->
                <td class="p-3">
                    <?= $row['created_at'] ?>
                </td>

                <!-- aksi -->
                <td class="p-3 space-x-2">

                    <a
                    href="edit_pesanan.php?id=<?= $row['id'] ?>"
                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-xl text-sm">

                        Edit

                    </a>

                    <a
                    href="hapus_pesanan.php?id=<?= $row['id'] ?>"
                    onclick="return confirm('Yakin ingin menghapus pesanan ini?')"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm">

                        Hapus

                    </a>

                    <?php if($row['status'] == 'pending'): ?>

                        <a
                        href="?selesai=<?= $row['id'] ?>"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm">

                             Selesai

                        </a>

                    <?php else: ?>

                        <span class="text-green-600 font-semibold">
                            Sudah Selesai
                        </span>

                    <?php endif; ?>

                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>