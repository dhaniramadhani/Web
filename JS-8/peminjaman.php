<?php

session_start();

date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/includes/koneksi.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $anggotaId =
        $_POST['anggota_id'] ?? '';

    $bukuId =
        $_POST['buku_id'] ?? '';

    $tanggalPinjam =
        $_POST['tanggal_pinjam'] ?? '';

    $tanggalKembali =
        $_POST['tanggal_kembali'] ?? '';


    $errors = [];

    $anggota = null;
    $buku = null;


    if (
        $anggotaId === '' ||
        !ctype_digit((string) $anggotaId)
    ) {

        $errors[] =
            'Anggota wajib dipilih.';

    } else {

        $stmt = $pdo->prepare(
            'SELECT * FROM anggota WHERE id = :id'
        );

        $stmt->execute([
            'id' => (int) $anggotaId
        ]);

        $anggota = $stmt->fetch();


        if (!$anggota) {
            $errors[] =
                'Data anggota tidak ditemukan.';
        }
    }


    if (
        $bukuId === '' ||
        !ctype_digit((string) $bukuId)
    ) {

        $errors[] =
            'Buku wajib dipilih.';

    } else {

        $stmt = $pdo->prepare(
            'SELECT * FROM buku WHERE id = :id'
        );

        $stmt->execute([
            'id' => (int) $bukuId
        ]);

        $buku = $stmt->fetch();


        if (!$buku) {

            $errors[] =
                'Data buku tidak ditemukan.';

        } elseif ((int) $buku['stok'] <= 0) {

            $errors[] =
                'Stok buku habis.';
        }
    }


    if (
        $tanggalPinjam === '' ||
        $tanggalKembali === ''
    ) {

        $errors[] =
            'Tanggal pinjam dan kembali wajib diisi.';

    } elseif (
        $tanggalKembali < $tanggalPinjam
    ) {

        $errors[] =
            'Tanggal kembali tidak boleh sebelum tanggal pinjam.';
    }


    if (empty($errors)) {

        try {

            $pdo->beginTransaction();


            $stmt = $pdo->prepare(
                'UPDATE buku
                 SET stok = stok - 1
                 WHERE id = :id
                 AND stok > 0'
            );


            $stmt->execute([
                'id' => (int) $bukuId
            ]);


            if ($stmt->rowCount() !== 1) {
                throw new Exception(
                    'Stok buku sudah habis.'
                );
            }


            $pdo->commit();


            if (!isset($_SESSION['transaksi'])) {
                $_SESSION['transaksi'] = [];
            }


            $_SESSION['transaksi'][] = [

                'id' =>
                    'PJM-' .
                    date('YmdHis') .
                    '-' .
                    random_int(100, 999),

                'anggota_id' =>
                    (int) $anggota['id'],

                'no_anggota' =>
                    $anggota['no_anggota'],

                'nama_anggota' =>
                    $anggota['nama'],

                'buku_id' =>
                    (int) $buku['id'],

                'buku' =>
                    $buku['judul'],

                'tanggal_pinjam' =>
                    $tanggalPinjam,

                'tanggal_kembali' =>
                    $tanggalKembali,

                'tanggal_dikembalikan' =>
                    '',

                'status' =>
                    'Dipinjam'

            ];


            $_SESSION['flash_transaksi'] = [
                'type' => 'success',
                'pesan' =>
                    'Peminjaman berhasil disimpan.'
            ];


            header('Location: riwayat.php');
            exit;


        } catch (Throwable $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }


            $errors[] = $e->getMessage();
        }
    }


    if (!empty($errors)) {

        $_SESSION['flash_transaksi'] = [
            'type' => 'error',
            'pesan' => implode(
                ' ',
                $errors
            )
        ];


        header('Location: peminjaman.php');
        exit;
    }
}


$page_title =
    'Peminjaman Buku';

$extra_scripts = [
    'assets/js/transaksi.js'
];


include __DIR__ . '/includes/header.php';


$flash =
    $_SESSION['flash_transaksi']
    ?? null;

unset(
    $_SESSION['flash_transaksi']
);


$daftarAnggota =
    $pdo->query(
        'SELECT * FROM anggota ORDER BY nama ASC'
    )
    ->fetchAll();


$daftarBuku =
    $pdo->query(
        'SELECT * FROM buku ORDER BY judul ASC'
    )
    ->fetchAll();

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
            Pilih anggota dan buku yang akan dipinjam.
        </p>

    </div>


    <?php if ($flash): ?>

        <div class="mb-5 rounded-xl border px-4 py-3 text-sm
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

            Tambahkan data Buku dan Anggota terlebih dahulu.

        </div>

    <?php endif; ?>


    <form
        method="post"
        id="form-peminjaman"
        class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">


        <div class="mb-5">

            <label
                for="anggota_id"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Anggota

            </label>


            <select
                id="anggota_id"
                name="anggota_id"
                required
                class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white">

                <option value="">
                    Pilih anggota
                </option>


                <?php foreach ($daftarAnggota as $anggota): ?>

                    <option
                        value="<?php echo (int) $anggota['id']; ?>">

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
                for="buku_id"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Buku

            </label>


            <select
                id="buku_id"
                name="buku_id"
                required
                class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white">

                <option value="">
                    Pilih buku
                </option>


                <?php foreach ($daftarBuku as $buku): ?>

                    <option
                        value="<?php echo (int) $buku['id']; ?>"
                        <?php
                        echo (int) $buku['stok'] <= 0
                            ? 'disabled'
                            : '';
                        ?>>

                        <?php
                        echo htmlspecialchars(
                            $buku['judul']
                        );
                        ?>

                        - Stok
                        <?php echo (int) $buku['stok']; ?>

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
                    required
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
                    required
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

include __DIR__ . '/includes/footer.php';

?>