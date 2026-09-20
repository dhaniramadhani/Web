<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$projectRoot = dirname(__DIR__);
$scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);

$relativePath = ltrim(
    str_replace(
        '\\',
        '/',
        substr($scriptDir, strlen($projectRoot))
    ),
    '/'
);

$base = $relativePath === ''
    ? ''
    : str_repeat(
        '../',
        substr_count($relativePath, '/') + 1
    );

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
        <?php
        if (isset($page_title)) {
            echo ' | ' . htmlspecialchars($page_title);
        }
        ?>
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
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600">
                        Dashboard
                    </a>
                </li>

                <li>
                    <a
                        href="<?php echo $base; ?>buku/list.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600">
                        Buku
                    </a>
                </li>

                <li>
                    <a
                        href="<?php echo $base; ?>anggota/list.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600">
                        Anggota
                    </a>
                </li>

                <li>
                    <a
                        href="<?php echo $base; ?>peminjaman.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600">
                        Peminjaman
                    </a>
                </li>

                <li>
                    <a
                        href="<?php echo $base; ?>pengembalian.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600">
                        Pengembalian
                    </a>
                </li>

                <li>
                    <a
                        href="<?php echo $base; ?>riwayat.php"
                        class="block px-4 py-2 rounded-lg text-slate-600 hover:bg-indigo-50 hover:text-indigo-600">
                        Riwayat
                    </a>
                </li>

                <li>
                    <a
                        href="<?php echo $base; ?>login.php"
                        class="block px-4 py-2 rounded-lg text-red-600 hover:bg-red-50">
                        Logout
                    </a>
                </li>

            </ul>

        </nav>

    </div>

</header>


<main class="w-full max-w-7xl mx-auto px-5 py-10 flex-1">