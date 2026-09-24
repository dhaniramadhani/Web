<?php

session_start();

date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/includes/koneksi.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id =
        trim($_POST['id'] ?? '');


    $indexTransaksi = null;


    foreach (
        $_SESSION['transaksi'] ?? []
        as $index => $transaksi
    ) {

        if (
            ($transaksi['id'] ?? '') === $id &&
            ($transaksi['status'] ?? '') === 'Dipinjam'
        ) {

            $indexTransaksi = $index;

            break;
        }
    }


    if ($indexTransaksi === null) {

        $_SESSION['flash_transaksi'] = [
            'type' => 'error',
            'pesan' =>
                'Transaksi tidak ditemukan.'
        ];

    } else {

        $transaksi =
            $_SESSION['transaksi']
            [$indexTransaksi];


        $bukuId =
            $transaksi['buku_id']
            ?? null;


        if ($bukuId === null) {

            $stmt = $pdo->prepare(
                'SELECT id
                 FROM buku
                 WHERE judul = :judul
                 LIMIT 1'
            );


            $stmt->execute([
                'judul' =>
                    $transaksi['buku']
            ]);


            $bukuId =
                $stmt->fetchColumn();
        }


        if (!$bukuId) {

            $_SESSION['flash_transaksi'] = [
                'type' => 'error',
                'pesan' =>
                    'Data buku tidak ditemukan.'
            ];

        } else {

            try {

                $pdo->beginTransaction();


                $stmt = $pdo->prepare(
                    'UPDATE buku
                     SET stok = stok + 1
                     WHERE id = :id'
                );


                $stmt->execute([
                    'id' => (int) $bukuId
                ]);


                if ($stmt->rowCount() !== 1) {

                    throw new Exception(
                        'Stok buku gagal diperbarui.'
                    );
                }


                $pdo->commit();


                $_SESSION['transaksi']
                    [$indexTransaksi]
                    ['status'] =
                    'Dikembalikan';


                $_SESSION['transaksi']
                    [$indexTransaksi]
                    ['tanggal_dikembalikan'] =
                    date('Y-m-d');


                $_SESSION['flash_transaksi'] = [
                    'type' => 'success',
                    'pesan' =>
                        'Pengembalian berhasil dikonfirmasi.'
                ];


            } catch (Throwable $e) {

                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }


                $_SESSION['flash_transaksi'] = [
                    'type' => 'error',
                    'pesan' =>
                        'Pengembalian gagal diproses.'
                ];
            }
        }
    }


    header(
        'Location: pengembalian.php'
    );

    exit;
}


$page_title =
    'Pengembalian Buku';

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


$daftarTransaksi =
    array_filter(
        $_SESSION['transaksi'] ?? [],
        function ($transaksi) {

            return (
                ($transaksi['status'] ?? '')
                === 'Dipinjam'
            );
        }
    );

?>


<section>

    <div class="mb-6">

        <p class="text-sm font-medium text-indigo-600 mb-1">
            Transaksi
        </p>

        <h2 class="text-2xl md:text-3xl font-bold">
            Pengembalian Buku
        </h2>

        <p class="text-slate-500 mt-2">
            Cari dan konfirmasi buku yang telah dikembalikan.
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


    <div class="mb-6">

        <label
            for="search-input"
            class="block text-sm font-semibold text-slate-700 mb-2">

            Cari Peminjaman

        </label>

        <input
            type="text"
            id="search-input"
            placeholder="Cari ID, anggota, atau buku..."
            class="w-full max-w-md bg-white border border-slate-300 rounded-xl px-4 py-3">

    </div>


    <div class="table-responsive overflow-x-auto bg-white border border-slate-200 rounded-2xl shadow-sm">

        <table class="w-full min-w-[900px]">

            <thead class="bg-slate-50 border-b border-slate-200">

                <tr>
                    <th class="text-left px-5 py-4">
                        ID
                    </th>

                    <th class="text-left px-5 py-4">
                        Anggota
                    </th>

                    <th class="text-left px-5 py-4">
                        Buku
                    </th>

                    <th class="text-left px-5 py-4">
                        Tgl Pinjam
                    </th>

                    <th class="text-left px-5 py-4">
                        Rencana Kembali
                    </th>

                    <th class="text-left px-5 py-4">
                        Aksi
                    </th>
                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

            <?php if (empty($daftarTransaksi)): ?>

                <tr>

                    <td
                        colspan="6"
                        class="px-5 py-8 text-center text-slate-500">

                        Tidak ada peminjaman aktif.

                    </td>

                </tr>

            <?php else: ?>

                <?php foreach ($daftarTransaksi as $transaksi): ?>

                    <tr>

                        <td class="px-5 py-4">
                            <?php
                            echo htmlspecialchars(
                                $transaksi['id']
                            );
                            ?>
                        </td>


                        <td class="px-5 py-4">
                            <?php
                            echo htmlspecialchars(
                                $transaksi['nama_anggota']
                            );
                            ?>
                        </td>


                        <td class="px-5 py-4">
                            <?php
                            echo htmlspecialchars(
                                $transaksi['buku']
                            );
                            ?>
                        </td>


                        <td class="px-5 py-4">
                            <?php
                            echo htmlspecialchars(
                                $transaksi['tanggal_pinjam']
                            );
                            ?>
                        </td>


                        <td class="px-5 py-4">
                            <?php
                            echo htmlspecialchars(
                                $transaksi['tanggal_kembali']
                            );
                            ?>
                        </td>


                        <td class="px-5 py-4">

                            <form
                                method="post"
                                class="form-pengembalian">

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?php
                                    echo htmlspecialchars(
                                        $transaksi['id']
                                    );
                                    ?>">

                                <button
                                    type="submit"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg">

                                    Kembalikan

                                </button>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<?php

include __DIR__ . '/includes/footer.php';

?>