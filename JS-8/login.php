<?php

session_start();


if (isset($_GET['logout'])) {

    unset($_SESSION['user']);

    header('Location: login.php');

    exit;
}


if (isset($_SESSION['user'])) {

    header('Location: index.php');

    exit;
}


$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username =
        trim($_POST['username'] ?? '');

    $password =
        trim($_POST['password'] ?? '');


    if (
        $username === '' ||
        $password === ''
    ) {

        $error =
            'Username dan password wajib diisi.';

    } elseif ($password === '12345') {

        $namaUser =
            str_replace(
                ['_', '-', '.'],
                ' ',
                $username
            );


        $namaUser =
            ucwords(
                strtolower($namaUser)
            );


        $_SESSION['user'] = [

            'username' => $username,

            'nama' => $namaUser

        ];


        header('Location: index.php');

        exit;

    } else {

        $error =
            'Password salah.';

    }
}

?>


<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        SIMPUS-Mini | Login
    </title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>


<body class="min-h-screen bg-slate-50 flex items-center justify-center px-5">


<main class="w-full max-w-md">


    <div class="text-center mb-8">

        <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-indigo-100 text-3xl rounded-2xl">

            📚

        </div>


        <h1 class="text-2xl font-bold text-indigo-600">

            SIMPUS-Mini

        </h1>


        <p class="text-slate-500 mt-2">

            Sistem Informasi Perpustakaan

        </p>

    </div>


    <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8">


        <div class="mb-6">

            <h2 class="text-xl font-bold text-slate-900">

                Login Petugas

            </h2>


            <p class="text-sm text-slate-500 mt-1">

                Masukkan username dan password untuk masuk.

            </p>

        </div>


        <?php if ($error !== ''): ?>

            <div class="mb-5 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-4 py-3">

                <?php
                echo htmlspecialchars($error);
                ?>

            </div>

        <?php endif; ?>


        <form
            method="post"
            action="login.php">


            <div class="mb-5">

                <label
                    for="username"
                    class="block text-sm font-semibold text-slate-700 mb-2">

                    Username

                </label>


                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Contoh: dhani"
                    value="<?php
                    echo htmlspecialchars(
                        $_POST['username'] ?? ''
                    );
                    ?>"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">

            </div>


            <div class="mb-6">

                <label
                    for="password"
                    class="block text-sm font-semibold text-slate-700 mb-2">

                    Password

                </label>


                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition">

            </div>


            <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl shadow-sm transition">

                Login

            </button>


        </form>

    </section>


    <p class="text-center text-sm text-slate-400 mt-6">

        Password Demo: 12345

    </p>


    <p class="text-center text-xs text-slate-400 mt-2">

        &copy; 2026 SIMPUS-Mini

    </p>


</main>


</body>

</html>