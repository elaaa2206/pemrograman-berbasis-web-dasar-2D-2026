<?php
session_start();

include '../config/koneksi.php';

$id = $_GET['id'];

$stmt = $conn->prepare("
SELECT * FROM menu_bakso
WHERE id=?
");

$stmt->bind_param("i",$id);

$stmt->execute();

$menu = $stmt->get_result()->fetch_assoc();

if(isset($_POST['pesan'])){

    $jumlah = $_POST['jumlah'];

    $total = $menu['harga'] * $jumlah;

    $user_id = $_SESSION['id'];

    // simpan pesanan
    $insert = $conn->prepare("
    INSERT INTO pesanan
    (user_id,menu_id,jumlah,total_harga,pembayaran)
    VALUES(?,?,?,?, 'belum_bayar')
    ");

    $insert->bind_param(
        "iiii",
        $user_id,
        $id,
        $jumlah,
        $total
    );

    if($insert->execute()){

        // cek pesanan pertama yang belum dibayar
        $cek = $conn->prepare("
        SELECT * FROM pesanan
        WHERE user_id=?
        AND pembayaran='belum_bayar'
        ORDER BY id ASC
        LIMIT 1
        ");

        $cek->bind_param("i", $user_id);

        $cek->execute();

        $hasil = $cek->get_result();

        $antrian = $hasil->fetch_assoc();

        $id_antrian = $antrian['id'];

        echo "
        <script>

        alert('Pesanan berhasil. Nomor antrian anda: A00$id_antrian');

        window.location='dashboard.php';

        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>

<meta charset='UTF-8'>

<meta name='viewport' content='width=device-width, initial-scale=1.0'>

<title>Pesan Menu</title>

<script src='https://cdn.tailwindcss.com'></script>

</head>

<body class='bg-orange-100 min-h-screen flex items-center justify-center'>

<div class='bg-white p-8 rounded-2xl shadow-lg w-full max-w-md'>

    <h1 class='text-3xl font-bold text-orange-600 mb-6'>
        <?= htmlspecialchars($menu['nama_menu']) ?>
    </h1>

    <p class='text-xl mb-5'>
        Harga:
        <b>
            Rp <?= number_format($menu['harga']) ?>
        </b>
    </p>

    <form method='POST'>

        <input
        type='number'
        name='jumlah'
        placeholder='Jumlah Pesanan'
        required
        class='w-full border border-gray-300 rounded-xl p-3 mb-4 focus:outline-none focus:ring-2 focus:ring-orange-400'>

        <button
        type='submit'
        name='pesan'
        class='w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl'>

            Pesan Sekarang

        </button>

    </form>

    <a
    href='dashboard.php'
    class='block text-center mt-5 bg-gray-300 hover:bg-gray-400 py-3 rounded-xl'>

        Kembali

    </a>

</div>

</body>
</html>