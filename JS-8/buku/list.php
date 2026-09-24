<?php

$page_title = "Daftar Buku";

require_once __DIR__ . '/../includes/koneksi.php';

include __DIR__ . '/../includes/header.php';


$flash = $_SESSION['flash'] ?? null;

unset($_SESSION['flash']);


$stmt = $pdo->query(
    'SELECT * FROM buku ORDER BY id DESC'
);

$daftarBuku = $stmt->fetchAll();

?>


<section>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>

            <p class="text-sm font-medium text-indigo-600 mb-1">
                Data Perpustakaan
            </p>

            <h2 class="text-2xl md:text-3xl font-bold">
                Daftar Buku
            </h2>

            <p class="text-slate-500 mt-2">
                Kelola data buku yang tersedia di perpustakaan.
            </p>

        </div>


        <a
            href="tambah.php"
            class="inline-flex justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-xl">

            + Tambah Buku

        </a>

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

            Cari Buku

        </label>

        <input
            type="text"
            id="search-input"
            placeholder="Cari judul atau pengarang..."
            class="w-full max-w-md bg-white border border-slate-300 rounded-xl px-4 py-3">

    </div>


    <div class="table-responsive overflow-x-auto bg-white border border-slate-200 rounded-2xl shadow-sm">

        <table class="w-full min-w-[800px]">

            <thead class="bg-slate-50 border-b border-slate-200">

                <tr>
                    <th class="text-left px-5 py-4">
                        Judul
                    </th>

                    <th class="text-left px-5 py-4">
                        Pengarang
                    </th>

                    <th class="text-left px-5 py-4">
                        Tahun
                    </th>

                    <th class="text-left px-5 py-4">
                        Kategori
                    </th>

                    <th class="text-left px-5 py-4">
                        Stok
                    </th>

                    <th class="text-left px-5 py-4">
                        Aksi
                    </th>
                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

            <?php if (empty($daftarBuku)): ?>

                <tr>

                    <td
                        colspan="6"
                        class="px-5 py-8 text-center text-slate-500">

                        Belum ada data buku.

                    </td>

                </tr>

            <?php else: ?>

                <?php foreach ($daftarBuku as $buku): ?>

                    <tr class="hover:bg-slate-50">

                        <td class="px-5 py-4 font-medium">

                            <?php
                            echo htmlspecialchars(
                                $buku['judul']
                            );
                            ?>

                        </td>


                        <td class="px-5 py-4">

                            <?php
                            echo htmlspecialchars(
                                $buku['pengarang']
                            );
                            ?>

                        </td>


                        <td class="px-5 py-4">

                            <?php
                            echo htmlspecialchars(
                                $buku['tahun']
                            );
                            ?>

                        </td>


                        <td class="px-5 py-4">

                            <?php
                            echo htmlspecialchars(
                                $buku['kategori'] ?? '-'
                            );
                            ?>

                        </td>


                        <td class="px-5 py-4">

                            <?php
                            echo (int) $buku['stok'];
                            ?>

                        </td>


                        <td class="px-5 py-4">

                            <div class="flex gap-2">

                                <button
                                    type="button"
                                    class="px-3 py-2 text-sm bg-amber-50 text-amber-700 rounded-lg">

                                    Edit

                                </button>


                                <button
                                    type="button"
                                    class="btn-hapus px-3 py-2 text-sm bg-red-50 text-red-600 rounded-lg">

                                    Hapus

                                </button>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</section>


<?php

include __DIR__ . '/../includes/footer.php';

?>