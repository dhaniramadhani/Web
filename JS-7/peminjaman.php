<?php

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $noAnggota =
        trim($_POST['no_anggota'] ?? '');

    $judulBuku =
        trim($_POST['buku'] ?? '');

    $tanggalPinjam =
        $_POST['tanggal_pinjam'] ?? '';

    $tanggalKembali =
        $_POST['tanggal_kembali'] ?? '';


    $errors = [];


    if ($noAnggota === '') {
        $errors[] =
            "Anggota wajib dipilih.";
    }


    if ($judulBuku === '') {
        $errors[] =
            "Buku wajib dipilih.";
    }


    if ($tanggalPinjam === '') {
        $errors[] =
            "Tanggal pinjam wajib diisi.";
    }


    if ($tanggalKembali === '') {
        $errors[] =
            "Tanggal kembali wajib diisi.";
    }


    if (
        $tanggalPinjam !== '' &&
        $tanggalKembali !== '' &&
        $tanggalKembali < $tanggalPinjam
    ) {
        $errors[] =
            "Tanggal kembali tidak boleh sebelum tanggal pinjam.";
    }


    $indexAnggota = null;

    foreach (
        $_SESSION['anggota'] ?? []
        as $index => $anggota
    ) {

        if (
            $anggota['no_anggota'] ===
            $noAnggota
        ) {
            $indexAnggota = $index;
            break;
        }
    }


    $indexBuku = null;

    foreach (
        $_SESSION['buku'] ?? []
        as $index => $buku
    ) {

        if (
            $buku['judul'] ===
            $judulBuku
        ) {
            $indexBuku = $index;
            break;
        }
    }


    if ($indexAnggota === null) {
        $errors[] =
            "Data anggota tidak ditemukan.";
    }


    if ($indexBuku === null) {

        $errors[] =
            "Data buku tidak ditemukan.";

    } elseif (
        $_SESSION['buku'][$indexBuku]['stok']
        <= 0
    ) {

        $errors[] =
            "Stok buku habis.";
    }


    if (!empty($errors)) {

        $_SESSION['flash_transaksi'] = [
            'type' => 'error',
            'pesan' => implode(
                ' ',
                $errors
            )
        ];


        header(
            'Location: peminjaman.php'
        );

        exit;
    }


    $anggota =
        $_SESSION['anggota'][$indexAnggota];


    $id =
        'PJM-' .
        date('YmdHis') .
        '-' .
        random_int(100, 999);


    if (
        !isset(
            $_SESSION['transaksi']
        )
    ) {
        $_SESSION['transaksi'] = [];
    }


    $_SESSION['transaksi'][] = [

        'id' => $id,

        'no_anggota' =>
            $anggota['no_anggota'],

        'nama_anggota' =>
            $anggota['nama'],

        'buku' =>
            $_SESSION['buku']
            [$indexBuku]['judul'],

        'tanggal_pinjam' =>
            $tanggalPinjam,

        'tanggal_kembali' =>
            $tanggalKembali,

        'tanggal_dikembalikan' =>
            '',

        'status' =>
            'Dipinjam'

    ];


    $_SESSION['buku']
        [$indexBuku]['stok']--;


    $_SESSION['flash_transaksi'] = [

        'type' => 'success',

        'pesan' =>
            'Peminjaman berhasil disimpan.'

    ];


    header(
        'Location: riwayat.php'
    );

    exit;
}



$page_title =
    "Peminjaman Buku";

$extra_scripts = [
    'assets/js/transaksi.js'
];

include __DIR__ .
    '/includes/header.php';


$flash =
    $_SESSION['flash_transaksi']
    ?? null;

unset(
    $_SESSION['flash_transaksi']
);


$daftarBuku =
    $_SESSION['buku'] ?? [];

$daftarAnggota =
    $_SESSION['anggota'] ?? [];

?>


<section class="max-w-3xl mx-auto">


    <div class="mb-6">

        <p class="text-sm font-medium text-indigo-600 mb-1">
            Transaksi
        </p>

        <h2 class="text-2xl md:text-3xl font-bold">
            Peminjaman Buku
        </h2>

        <p class="text-slate-500 mt-2">
            Pilih anggota dan buku yang akan
            dipinjam.
        </p>

    </div>


    <?php if ($flash): ?>

        <div
            class="mb-5 rounded-xl border px-4 py-3 text-sm
            <?php
            echo $flash['type'] === 'success'
                ? 'bg-emerald-50 border-emerald-200 text-emerald-700'
                : 'bg-red-50 border-red-200 text-red-600';
            ?>">

            <?php
            echo htmlspecialchars(
                $flash['pesan']
            );
            ?>

        </div>

    <?php endif; ?>


    <?php if (
        empty($daftarBuku) ||
        empty($daftarAnggota)
    ): ?>

        <div class="bg-amber-50 border border-amber-200 text-amber-700 rounded-xl p-4 mb-5">

            Tambahkan data Buku dan Anggota
            terlebih dahulu sebelum melakukan
            peminjaman.

        </div>

    <?php endif; ?>


    <form
        id="form-peminjaman"
        method="post"
        class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">


        <div class="mb-5">

            <label
                for="no_anggota"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Anggota

            </label>


            <select
                id="no_anggota"
                name="no_anggota"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white">

                <option value="">
                    Pilih anggota
                </option>


                <?php
                foreach (
                    $daftarAnggota
                    as $anggota
                ):
                ?>

                    <option
                        value="<?php
                        echo htmlspecialchars(
                            $anggota['no_anggota']
                        );
                        ?>">

                        <?php
                        echo htmlspecialchars(
                            $anggota['no_anggota'] .
                            ' - ' .
                            $anggota['nama']
                        );
                        ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div class="mb-5">

            <label
                for="buku"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Buku

            </label>


            <select
                id="buku"
                name="buku"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white">

                <option value="">
                    Pilih buku
                </option>


                <?php
                foreach (
                    $daftarBuku
                    as $buku
                ):
                ?>

                    <option
                        value="<?php
                        echo htmlspecialchars(
                            $buku['judul']
                        );
                        ?>"
                        <?php
                        echo $buku['stok'] <= 0
                            ? 'disabled'
                            : '';
                        ?>>

                        <?php
                        echo htmlspecialchars(
                            $buku['judul']
                        );
                        ?>

                        -
                        stok
                        <?php
                        echo (int) $buku['stok'];
                        ?>

                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">


            <div>

                <label
                    for="tanggal-pinjam"
                    class="block text-sm font-semibold text-slate-700 mb-2">

                    Tanggal Pinjam

                </label>

                <input
                    type="date"
                    id="tanggal-pinjam"
                    name="tanggal_pinjam"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

            </div>


            <div>

                <label
                    for="tanggal-kembali"
                    class="block text-sm font-semibold text-slate-700 mb-2">

                    Tanggal Kembali

                </label>

                <input
                    type="date"
                    id="tanggal-kembali"
                    name="tanggal_kembali"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3">

            </div>


        </div>


        <div class="flex justify-end pt-5 border-t border-slate-100">

            <button
                type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-xl">

                Simpan Peminjaman

            </button>

        </div>

    </form>

</section>


<?php

include __DIR__ .
    '/includes/footer.php';

?>