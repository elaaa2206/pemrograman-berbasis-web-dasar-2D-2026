<?php
session_start();

include '../config/koneksi.php';

$pesan = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];

    $password = $_POST['password'];

    $stmt = $conn->prepare("
    SELECT * FROM users
    WHERE username=?
    ");

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $data = $result->fetch_assoc();

        if(password_verify($password, $data['password'])){

            $_SESSION['login'] = true;

            $_SESSION['id'] = $data['id'];

            $_SESSION['nama'] = $data['nama'];

            $_SESSION['role'] = $data['role'];

            // redirect role
            if($data['role'] == 'admin'){

                header("Location: ../admin/dashboard.php");

            } else {

                header("Location: ../user/dashboard.php");

            }

            exit;

        } else {

            $pesan = "
            <div class='bg-red-100 text-red-700 p-4 rounded-xl mb-4'>
                Password salah
            </div>
            ";
        }

    } else {

        $pesan = "
        <div class='bg-red-100 text-red-700 p-4 rounded-xl mb-4'>
            Username tidak ditemukan
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

<title>Login</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">

    <h1 class="text-3xl font-bold text-orange-600 text-center mb-6">
        Login Toko Bakso
    </h1>

    <?= $pesan ?>

    <form method="POST">

        <input
        type="text"
        name="username"
        placeholder="Username"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-4 focus:outline-none focus:ring-2 focus:ring-orange-400">

        <input
        type="password"
        name="password"
        placeholder="Password"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-4 focus:outline-none focus:ring-2 focus:ring-orange-400">

        <button
        type="submit"
        name="login"
        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition">

            Login

        </button>

    </form>

    <p class="text-center mt-5 text-gray-600">

        Belum punya akun?

        <a
        href="register.php"
        class="text-orange-500 font-semibold hover:underline">

            Register

        </a>

    </p>

</div>

</body>
</html>