<?php
include '../auth/cek_login.php';
include '../config/koneksi.php';

$user_id = $_SESSION['id'];

// ambil semua pesanan belum bayar
$pesanan = $conn->prepare("
SELECT 
    menu_bakso.nama_menu,
    menu_bakso.harga,
    pesanan.jumlah,
    pesanan.total_harga
FROM pesanan
JOIN menu_bakso 
ON pesanan.menu_id = menu_bakso.id
WHERE pesanan.user_id=?
AND pesanan.pembayaran='belum_bayar'
");

$pesanan->bind_param("i", $user_id);

$pesanan->execute();

$data_pesanan = $pesanan->get_result();

// total keseluruhan
$total_query = $conn->prepare("
SELECT SUM(total_harga) as total
FROM pesanan
WHERE user_id=?
AND pembayaran='belum_bayar'
");

$total_query->bind_param("i", $user_id);

$total_query->execute();

$total_data = $total_query->get_result()->fetch_assoc();

$total = $total_data['total'];

$pesan = "";

if(isset($_POST['bayar'])){

    $uang = $_POST['uang'];

    // uang kurang
    if($uang < $total){

        $kurang = $total - $uang;

        $pesan = "
        <div class='bg-red-100 text-red-700 p-4 rounded-xl mb-4'>
            Uang anda kurang Rp " . number_format($kurang) . "
        </div>
        ";
    }

    // uang lebih
    elseif($uang > $total){

        $kembalian = $uang - $total;

        $update = $conn->prepare("
        UPDATE pesanan
        SET pembayaran='sudah_bayar'
        WHERE user_id=?
        AND pembayaran='belum_bayar'
        ");

        $update->bind_param("i", $user_id);

        $update->execute();

        echo "
        <script>

        alert('Pembayaran berhasil, kembalian anda Rp " . number_format($kembalian) . ". Silahkan tunggu pesanan anda');

        window.location='dashboard.php';

        </script>
        ";

        exit;
    }

    // uang pas
    else {

        $update = $conn->prepare("
        UPDATE pesanan
        SET pembayaran='sudah_bayar'
        WHERE user_id=?
        AND pembayaran='belum_bayar'
        ");

        $update->bind_param("i", $user_id);

        $update->execute();

        echo "
        <script>

        alert('Pembayaran berhasil, silahkan tunggu pesanan anda');

        window.location='dashboard.php';

        </script>
        ";

        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pembayaran</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-100 min-h-screen flex items-center justify-center p-5">

<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-2xl">

    <h1 class="text-3xl font-bold text-orange-600 mb-6 text-center">
        Detail Pembayaran
    </h1>

    <?= $pesan ?>

    <div class="overflow-x-auto mb-6">

        <table class="w-full border border-gray-300">

            <tr class="bg-orange-500 text-white">

                <th class="p-3">Menu</th>
                <th class="p-3">Harga</th>
                <th class="p-3">Jumlah</th>
                <th class="p-3">Subtotal</th>

            </tr>

            <?php while($row = $data_pesanan->fetch_assoc()): ?>

            <tr class="text-center border-b">

                <td class="p-3">
                    <?= htmlspecialchars($row['nama_menu']) ?>
                </td>

                <td class="p-3">
                    Rp <?= number_format($row['harga']) ?>
                </td>

                <td class="p-3">
                    <?= $row['jumlah'] ?>x
                </td>

                <td class="p-3 font-semibold">
                    Rp <?= number_format($row['total_harga']) ?>
                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

    <div class="bg-orange-100 p-5 rounded-2xl mb-5">

        <div class="flex justify-between items-center">

            <h2 class="text-2xl font-bold text-orange-700">
                Total Keseluruhan
            </h2>

            <h2 class="text-3xl font-bold text-orange-500">
                Rp <?= number_format($total) ?>
            </h2>

        </div>

    </div>

    <form method="POST">

        <input
        type="number"
        name="uang"
        placeholder="Masukkan uang pembayaran"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-4 focus:outline-none focus:ring-2 focus:ring-orange-400">

        <button
        type="submit"
        name="bayar"
        class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-xl transition">

            Bayar Sekarang

        </button>

    </form>

    <a
    href="pesanan_saya.php"
    class="block text-center mt-5 bg-gray-300 hover:bg-gray-400 text-gray-800 py-3 rounded-xl transition">

        Kembali

    </a>

</div>

</body>
</html>