<?php
include '../config/koneksi.php';

if(isset($_POST['register'])){

    $nama = htmlspecialchars($_POST['nama']);

    $username = htmlspecialchars($_POST['username']);

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    // cek username sudah ada atau belum
    $cek = $conn->prepare("
    SELECT id FROM users
    WHERE username=?
    ");

    $cek->bind_param("s", $username);

    $cek->execute();

    $hasil = $cek->get_result();

    // jika username sudah dipakai
    if($hasil->num_rows > 0){

        echo "
        <script>

        alert('Username sudah digunakan');

        window.history.back();

        </script>
        ";

    } else {

        // simpan user baru
        $stmt = $conn->prepare("
        INSERT INTO users
        (nama, username, password, role)
        VALUES(?,?,?,'user')
        ");

        $stmt->bind_param(
            "sss",
            $nama,
            $username,
            $password
        );

        if($stmt->execute()){

            echo "
            <script>

            alert('Registrasi berhasil');

            window.location='login.php';

            </script>
            ";

        } else {

            echo "
            <script>

            alert('Gagal register');

            </script>
            ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">

    <h1 class="text-3xl font-bold text-orange-600 text-center mb-6">
        Register
    </h1>

    <form method="POST">

        <input
        type="text"
        name="nama"
        placeholder="Nama Lengkap"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-4">

        <input
        type="text"
        name="username"
        placeholder="Username"
        required
        class="w-full border border-gray-300 rounded-xl p-3 mb-4">

        <input
        type="password"
        name="password"
        placeholder="Password"
        required
        minlength="6"
        class="w-full border border-gray-300 rounded-xl p-3 mb-5">

        <button
        type="submit"
        name="register"
        class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl">

            Register

        </button>

    </form>

    <p class="text-center mt-5">

        Sudah punya akun?

        <a
        href="login.php"
        class="text-orange-600 font-semibold">

            Login

        </a>

    </p>

</div>

</body>
</html>