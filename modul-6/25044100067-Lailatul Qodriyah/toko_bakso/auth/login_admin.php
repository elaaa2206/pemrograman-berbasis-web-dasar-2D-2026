<?php
session_start();

$pesan = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];

    $password = $_POST['password'];

    // login khusus admin
    if($username == "elaaa22" && $password == "221006"){

        $_SESSION['login'] = true;

        $_SESSION['role'] = "admin";

        $_SESSION['nama'] = "Admin";

        header("Location: ../admin/dashboard.php");

        exit;

    } else {

        $pesan = "
        <div class='bg-red-100 text-red-700 p-4 rounded-xl mb-4'>
            Username atau password admin salah
        </div>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login Admin</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-red-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md">

    <h1 class="text-3xl font-bold text-red-600 text-center mb-6">
        Login Admin
    </h1>

    <?= $pesan ?>

    <form method="POST">

        <input
        type="text"
        name="username"
        placeholder="Username Admin"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-4">

        <input
        type="password"
        name="password"
        placeholder="Password Admin"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-4">

        <button
        type="submit"
        name="login"
        class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl">

            Login Admin

        </button>

    </form>

    <a
    href="../index.php"
    class="block text-center mt-5 text-gray-500 hover:text-black">

        Kembali

    </a>

</div>

</body>
</html>