<?php
include '../auth/cek_admin.php';
include '../config/koneksi.php';

//untuk mengambil id dari link di atas
$id = $_GET['id'];

//mencari data pesanan berdasarkan id
$query = $conn->prepare("
SELECT * FROM pesanan
WHERE id=?
");

// bind param disini berfunsi sebagai penghubung ke sql yang dimana i itu integer dan id itu untuk dimana idnya
$query->bind_param("i", $id);

//mengeksekusi query didatabase
$query->execute();

//mengambil hasil query  dan di jadikan satu baris 
$data = $query->get_result()->fetch_assoc();

// kalau tombol update di tekan maka  perintah akannn dijalankan
if(isset($_POST['update'])){

    $jumlah = $_POST['jumlah'];

    //mengubah pesanan berdasarkan id con disini berfungsi sebaggai penghubung ke database
    $update = $conn->prepare("
    UPDATE pesanan
    SET jumlah=?
    WHERE id=?
    ");
// kenapa i nya dua karna jumlah dan id merupakan integer
    $update->bind_param("ii", $jumlah, $id);

    //menyimpan perubahan ke database
    $update->execute();
//  header adalah perintah di  halamna browser yang di mana lokasinya di pesana php
    header("Location: pesanan.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Pesanan</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

    <h1 class="text-3xl font-bold text-orange-600 mb-6">
        Edit Pesanan
    </h1>

    <form method="POST">

        <input
        type="number"
        name="jumlah"
        value="<?= $data['jumlah'] ?>"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-4">

        <button
        type="submit"
        name="update"
        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl">

            Update

        </button>

    </form>

</div>

</body>
</html>