<?php
include '../auth/cek_admin.php';
include '../config/koneksi.php';

// ambil user
$users = $conn->query("
SELECT * FROM users
WHERE role='user'
");

// ambil menu
$menu = $conn->query("
SELECT * FROM menu_bakso
");

if(isset($_POST['simpan'])){

    $user_id = $_POST['user_id'];

    $menu_id = $_POST['menu_id'];

    $jumlah = $_POST['jumlah'];

    // ambil harga menu
    $harga = $conn->prepare("
    SELECT harga FROM menu_bakso
    WHERE id=?
    ");

    $harga->bind_param("i", $menu_id);

    $harga->execute();

    $hasil_harga = $harga->get_result()->fetch_assoc();

    $total = $hasil_harga['harga'] * $jumlah;

    // simpan pesanan
    $insert = $conn->prepare("
    INSERT INTO pesanan
    (user_id,menu_id,jumlah,total_harga,pembayaran,status)
    VALUES(?,?,?,?, 'belum_bayar','pending')
    ");

    $insert->bind_param(
        "iiii",
        $user_id,
        $menu_id,
        $jumlah,
        $total
    );

    $insert->execute();

    header("Location: pesanan.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Pesanan</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md">

    <h1 class="text-3xl font-bold text-orange-600 mb-6">
        Tambah Pesanan
    </h1>

    <form method="POST">

        <!-- pilih pelanggan -->
        <label class="font-semibold">
            Pilih Pelanggan
        </label>

        <select
        name="user_id"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-4">

            <option value="">
                -- Pilih Pelanggan --
            </option>

            <?php while($u = $users->fetch_assoc()): ?>

                <option value="<?= $u['id'] ?>">
                    <?= htmlspecialchars($u['nama']) ?>
                </option>

            <?php endwhile; ?>

        </select>

        <!-- pilih menu -->
        <label class="font-semibold">
            Pilih Menu
        </label>

        <select
        name="menu_id"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-4">

            <option value="">
                -- Pilih Menu --
            </option>

            <?php while($m = $menu->fetch_assoc()): ?>

                <option value="<?= $m['id'] ?>">
                    <?= htmlspecialchars($m['nama_menu']) ?>
                    - Rp <?= number_format($m['harga']) ?>
                </option>

            <?php endwhile; ?>

        </select>

        <!-- jumlah -->
        <label class="font-semibold">
            Jumlah
        </label>

        <input
        type="number"
        name="jumlah"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-5">

        <!-- tombol -->
        <button
        type="submit"
        name="simpan"
        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl">

            Simpan Pesanan

        </button>

    </form>

    <a
    href="pesanan.php"
    class="block text-center mt-5 text-gray-500 hover:text-black">

        Kembali

    </a>

</div>

</body>
</html>