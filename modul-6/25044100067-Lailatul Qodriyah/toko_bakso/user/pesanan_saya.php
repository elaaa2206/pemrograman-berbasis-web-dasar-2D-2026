<?php
include '../auth/cek_login.php';
include '../config/koneksi.php';

$user_id = $_SESSION['id'];

$query = $conn->prepare("
SELECT 
    pesanan.id,
    menu_bakso.nama_menu,
    pesanan.jumlah,
    pesanan.total_harga,
    pesanan.pembayaran,
    pesanan.created_at
FROM pesanan
JOIN menu_bakso 
ON pesanan.menu_id = menu_bakso.id
WHERE pesanan.user_id = ?
ORDER BY pesanan.id DESC
");

$query->bind_param("i", $user_id);

$query->execute();

$data = $query->get_result();

$total_bayar = 0;

$belum_bayar = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesanan Saya</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-orange-100 min-h-screen p-10">

<div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow-lg">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold text-orange-600">
            Pesanan Saya
        </h1>

        <a
        href="dashboard.php"
        class="bg-gray-300 hover:bg-gray-400 px-5 py-2 rounded-xl">

            Kembali

        </a>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full border border-gray-300">

            <tr class="bg-orange-500 text-white">

                <th class="p-3">No</th>
                <th class="p-3">Menu</th>
                <th class="p-3">Jumlah</th>
                <th class="p-3">Total</th>
                <th class="p-3">Status</th>
                <th class="p-3">Tanggal</th>

            </tr>

            <?php
            $no = 1;

            while($row = $data->fetch_assoc()):

            if($row['pembayaran'] == 'belum_bayar'){
                $total_bayar += $row['total_harga'];
                $belum_bayar = true;
            }
            ?>

            <tr class="text-center border-b">

                <td class="p-3">
                    <?= $no++ ?>
                </td>

                <td class="p-3">
                    <?= htmlspecialchars($row['nama_menu']) ?>
                </td>

                <td class="p-3">
                    <?= $row['jumlah'] ?>
                </td>

                <td class="p-3">
                    Rp <?= number_format($row['total_harga']) ?>
                </td>

                <td class="p-3">

                    <?php if($row['pembayaran'] == 'belum_bayar'): ?>

                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm">
                            Belum Dibayar
                        </span>

                    <?php else: ?>

                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm">
                            Sudah Dibayar
                        </span>

                    <?php endif; ?>

                </td>

                <td class="p-3">
                    <?= $row['created_at'] ?>
                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

    <div class="mt-8 bg-orange-100 p-5 rounded-2xl">

        <h2 class="text-2xl font-bold text-orange-700 mb-3">
            Total Yang Harus Dibayar
        </h2>

        <p class="text-3xl font-bold">
            Rp <?= number_format($total_bayar) ?>
        </p>

        <?php if($belum_bayar): ?>

            <div class="mt-4 bg-red-100 text-red-700 p-4 rounded-xl">

                Pesanan belum anda bayar

            </div>

            <a
            href="bayar.php"
            class="inline-block mt-5 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl">

                Bayar Semua Pesanan

            </a>

        <?php else: ?>

            <div class="mt-4 bg-green-100 text-green-700 p-4 rounded-xl">

                Semua pesanan sudah dibayar

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>