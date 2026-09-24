<?php

$page_title = "Tambah Buku";

include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;

unset($_SESSION['flash']);

?>


<section class="max-w-2xl mx-auto">

    <div class="mb-6">

        <p class="text-sm font-medium text-indigo-600 mb-1">
            Manajemen Buku
        </p>

        <h2 class="text-2xl md:text-3xl font-bold">
            Tambah Buku
        </h2>

        <p class="text-slate-500 mt-2">
            Tambahkan data buku baru ke perpustakaan.
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
            echo htmlspecialchars($flash['pesan']);
            ?>

        </div>

    <?php endif; ?>


    <form
        id="form-tambah"
        method="post"
        action="proses_tambah.php"
        novalidate
        class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">


        <div class="mb-5">

            <label
                for="judul"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Judul Buku

            </label>

            <input
                type="text"
                id="judul"
                name="judul"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

        </div>


        <div class="mb-5">

            <label
                for="pengarang"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Pengarang

            </label>

            <input
                type="text"
                id="pengarang"
                name="pengarang"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

        </div>


        <div class="mb-5">

            <label
                for="tahun"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Tahun Terbit

            </label>

            <input
                type="number"
                id="tahun"
                name="tahun"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

        </div>


        <div class="mb-5">

            <label
                for="isbn"
                class="block text-sm font-semibold text-slate-700 mb-2">

                ISBN

            </label>

            <input
                type="text"
                id="isbn"
                name="isbn"
                placeholder="Opsional"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

        </div>


        <div class="mb-5">

            <label
                for="stok"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Stok

            </label>

            <input
                type="number"
                id="stok"
                name="stok"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

        </div>


        <div class="mb-6">

            <label
                for="kategori"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Kategori

            </label>

            <select
                id="kategori"
                name="kategori"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

                <option value="">
                    Pilih kategori
                </option>

                <option value="fiksi">
                    Fiksi
                </option>

                <option value="non-fiksi">
                    Non-Fiksi
                </option>

                <option value="referensi">
                    Referensi
                </option>

            </select>

        </div>


        <div class="flex justify-end gap-3 pt-5 border-t border-slate-100">

            <a
                href="list.php"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-5 py-2.5 rounded-xl">

                Batal

            </a>

            <button
                type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-xl">

                Simpan Buku

            </button>

        </div>

    </form>

</section>


<?php

include __DIR__ . '/../includes/footer.php';

?>