<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Toko Bakso</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-orange-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md text-center">

    <h1 class="text-4xl font-bold text-orange-600 mb-3">
        Toko Bakso
    </h1>

    <p class="text-gray-500 mb-8">
        Silahkan pilih login
    </p>

    <div class="space-y-4">

        <a
        href="auth/login_admin.php"
        class="block bg-red-500 hover:bg-red-600 text-white py-4 rounded-2xl text-lg font-semibold">

            Login Admin

        </a>

        <a
        href="auth/login.php"
        class="block bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-2xl text-lg font-semibold">

            Login Pelanggan

        </a>

    </div>

</div>

</body>
</html>