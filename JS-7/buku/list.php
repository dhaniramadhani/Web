<?php

$page_title = "Daftar Buku";

include __DIR__ . '/../includes/header.php';


$flash =
    $_SESSION['flash'] ?? null;

unset($_SESSION['flash']);


$daftarBuku =
    $_SESSION['buku'] ?? [];

?>


<section>

    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">

        <div>

            <p class="text-sm font-medium text-indigo-600 mb-1">
                Manajemen Buku
            </p>

            <h2 class="text-2xl md:text-3xl font-bold">
                Daftar Buku
            </h2>

            <p class="text-slate-500 mt-2">
                Data buku disimpan sementara menggunakan PHP Session.
            </p>

        </div>


        <a
            href="tambah.php"
            class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-xl">

            + Tambah Buku

        </a>

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
            echo htmlspecialchars($flash['pesan']);
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
            class="w-full max-w-md bg-white border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

    </div>


    <div class="table-responsive overflow-x-auto bg-white border border-slate-200 rounded-2xl shadow-sm">

        <table class="w-full min-w-[800px]">

            <thead class="bg-slate-50 border-b border-slate-200">

                <tr>

                    <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase">
                        Judul
                    </th>

                    <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase">
                        Pengarang
                    </th>

                    <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase">
                        Tahun
                    </th>

                    <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase">
                        Stok
                    </th>

                    <th class="text-left px-5 py-4 text-xs font-semibold text-slate-500 uppercase">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

            <?php if (empty($daftarBuku)): ?>

                <tr>

                    <td
                        colspan="5"
                        class="px-5 py-8 text-center text-slate-500">

                        Belum ada data buku.
                        Silakan tambah melalui menu Tambah Buku.

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
                                (string) $buku['tahun']
                            );
                            ?>

                        </td>


                        <td class="px-5 py-4">

                            <?php
                            echo htmlspecialchars(
                                (string) $buku['stok']
                            );
                            ?>

                        </td>


                        <td class="px-5 py-4">

                            <div class="flex gap-2">

                                <button
                                    type="button"
                                    class="bg-sky-50 text-sky-700 px-3 py-2 rounded-lg">

                                    Edit

                                </button>

                                <button
                                    type="button"
                                    class="btn-hapus bg-red-50 text-red-600 px-3 py-2 rounded-lg">

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