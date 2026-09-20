<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$currentFolder =
    basename(
        dirname($_SERVER['SCRIPT_NAME'])
    );


if (
    $currentFolder === 'buku' ||
    $currentFolder === 'anggota'
) {

    $base = '../';

} else {

    $base = '';

}


$namaLogin =
    $_SESSION['user']['nama']
    ?? 'Petugas';

$usernameLogin =
    $_SESSION['user']['username']
    ?? '';

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>

        SIMPUS-Mini

        <?php if (isset($page_title)): ?>

            | <?php
            echo htmlspecialchars(
                $page_title
            );
            ?>

        <?php endif; ?>

    </title>


    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>


<body class="min-h-screen bg-slate-50 text-slate-900 flex flex-col">


<header class="bg-white border-b border-slate-200 sticky top-0 z-50">


    <div class="relative w-full max-w-7xl mx-auto px-5 py-4 flex items-center justify-between">


        <a
            href="<?php echo $base; ?>index.php"
            class="text-xl font-bold text-indigo-600">

            SIMPUS-Mini

        </a>


        <button
            type="button"
            id="nav-toggle-btn"
            aria-label="Buka menu navigasi"
            aria-expanded="false"
            class="md:hidden text-2xl text-slate-700">

            ☰

        </button>


        <nav
            id="main-nav"
            class="hidden absolute top-full left-0 w-full bg-white border-b border-slate-200 shadow-md p-4
                   md:block md:static md:w-auto md:border-0 md:shadow-none md:p-0">


            <ul class="flex flex-col gap-2 md:flex-row md:items-center">


                <li>

                    <a
                        href="<?php echo $base; ?>index.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">

                        Dashboard

                    </a>

                </li>


                <li>

                    <a
                        href="<?php echo $base; ?>buku/list.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">

                        Buku

                    </a>

                </li>


                <li>

                    <a
                        href="<?php echo $base; ?>anggota/list.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">

                        Anggota

                    </a>

                </li>


                <li>

                    <a
                        href="<?php echo $base; ?>peminjaman.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">

                        Peminjaman

                    </a>

                </li>


                <li>

                    <a
                        href="<?php echo $base; ?>pengembalian.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">

                        Pengembalian

                    </a>

                </li>


                <li>

                    <a
                        href="<?php echo $base; ?>riwayat.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition">

                        Riwayat

                    </a>

                </li>


                <?php if (isset($_SESSION['user'])): ?>

                    <li class="md:ml-3 md:pl-4 md:border-l md:border-slate-200">

                        <div class="px-4 py-1 md:px-0">

                            <p class="text-sm font-semibold text-slate-700">

                                <?php
                                echo htmlspecialchars(
                                    $namaLogin
                                );
                                ?>

                            </p>


                            <p class="text-xs text-slate-400">

                                @<?php
                                echo htmlspecialchars(
                                    $usernameLogin
                                );
                                ?>

                            </p>

                        </div>

                    </li>


                    <li>

                        <a
                            href="<?php echo $base; ?>login.php?logout=1"
                            class="block px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 transition">

                            Logout

                        </a>

                    </li>

                <?php endif; ?>


            </ul>


        </nav>


    </div>


</header>


<main class="w-full max-w-7xl mx-auto px-5 py-10 flex-1">