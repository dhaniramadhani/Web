<?php

session_start();


if (!isset($_SESSION['user'])) {

    header('Location: login.php');

    exit;
}


$page_title =
    "Dashboard";


$namaUser =
    $_SESSION['user']['nama'];


$totalBuku =
    count(
        $_SESSION['buku']
        ?? []
    );


$totalAnggota =
    count(
        $_SESSION['anggota']
        ?? []
    );


$daftarTransaksi =
    $_SESSION['transaksi']
    ?? [];


$totalDipinjam = 0;


foreach (
    $daftarTransaksi
    as $transaksi
) {

    if (
        ($transaksi['status'] ?? '')
        === 'Dipinjam'
    ) {

        $totalDipinjam++;

    }
}


include __DIR__ .
    '/includes/header.php';

?>


<section class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-2xl p-6 md:p-10 text-white mb-10 shadow-sm">


    <p class="text-indigo-100 text-sm font-medium mb-2">

        Dashboard Petugas

    </p>


    <h2 class="text-2xl md:text-3xl font-bold mb-3">

        Selamat Datang,

        <?php
        echo htmlspecialchars(
            $namaUser
        );
        ?>

        👋

    </h2>


    <p class="text-indigo-100 max-w-2xl leading-relaxed">

        Kelola data buku, anggota,
        peminjaman, pengembalian,
        dan riwayat perpustakaan
        melalui SIMPUS-Mini.

    </p>


</section>



<section class="mb-10">


    <div class="mb-6">

        <h2 class="text-xl font-bold">

            Ringkasan

        </h2>


        <p class="text-sm text-slate-500 mt-1">

            Informasi perpustakaan saat ini.

        </p>

    </div>



    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">


        <article class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">


            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-50 text-2xl mb-4">

                📚

            </div>


            <p class="text-sm text-slate-500">

                Total Buku

            </p>


            <h3 class="text-3xl font-bold mt-1">

                <?php
                echo $totalBuku;
                ?>

            </h3>


        </article>



        <article class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">


            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-50 text-2xl mb-4">

                👥

            </div>


            <p class="text-sm text-slate-500">

                Total Anggota

            </p>


            <h3 class="text-3xl font-bold mt-1">

                <?php
                echo $totalAnggota;
                ?>

            </h3>


        </article>



        <article class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">


            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-50 text-2xl mb-4">

                📖

            </div>


            <p class="text-sm text-slate-500">

                Sedang Dipinjam

            </p>


            <h3 class="text-3xl font-bold mt-1">

                <?php
                echo $totalDipinjam;
                ?>

            </h3>


        </article>


    </div>


</section>



<section>


    <div class="mb-6">

        <h2 class="text-xl font-bold">

            Menu Utama

        </h2>


        <p class="text-sm text-slate-500 mt-1">

            Pilih aktivitas perpustakaan
            yang ingin dilakukan.

        </p>

    </div>



    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


        <a
            href="peminjaman.php"
            class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition">


            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-50 text-2xl mb-4">

                📥

            </div>


            <h3 class="text-lg font-bold group-hover:text-indigo-600 transition">

                Peminjaman Buku

            </h3>


            <p class="text-sm text-slate-500 mt-2">

                Catat transaksi peminjaman
                buku oleh anggota.

            </p>


            <p class="text-indigo-600 font-medium text-sm mt-5">

                Buka menu →

            </p>


        </a>



        <a
            href="pengembalian.php"
            class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition">


            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-50 text-2xl mb-4">

                📤

            </div>


            <h3 class="text-lg font-bold group-hover:text-indigo-600 transition">

                Pengembalian Buku

            </h3>


            <p class="text-sm text-slate-500 mt-2">

                Konfirmasi buku yang
                telah dikembalikan.

            </p>


            <p class="text-indigo-600 font-medium text-sm mt-5">

                Buka menu →

            </p>


        </a>



        <a
            href="riwayat.php"
            class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition">


            <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-50 text-2xl mb-4">

                🕘

            </div>


            <h3 class="text-lg font-bold group-hover:text-indigo-600 transition">

                Riwayat

            </h3>


            <p class="text-sm text-slate-500 mt-2">

                Lihat seluruh transaksi
                peminjaman dan pengembalian.

            </p>


            <p class="text-indigo-600 font-medium text-sm mt-5">

                Buka menu →

            </p>


        </a>


    </div>


</section>


<?php

include __DIR__ .
    '/includes/footer.php';

?>