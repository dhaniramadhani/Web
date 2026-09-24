<?php

$page_title = "Tambah Anggota";

include __DIR__ . '/../includes/header.php';


$flash =
    $_SESSION['flash'] ?? null;

unset($_SESSION['flash']);

?>


<section class="max-w-2xl mx-auto">

    <div class="mb-6">

        <p class="text-sm font-medium text-indigo-600 mb-1">
            Manajemen Anggota
        </p>

        <h2 class="text-2xl md:text-3xl font-bold">
            Tambah Anggota
        </h2>

        <p class="text-slate-500 mt-2">
            Tambahkan anggota baru ke perpustakaan.
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
        id="form-anggota"
        method="post"
        action="proses_tambah.php"
        novalidate
        class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">


        <div class="mb-5">

            <label
                for="no_anggota"
                class="block text-sm font-semibold text-slate-700 mb-2">

                No. Anggota

            </label>

            <input
                type="text"
                id="no_anggota"
                name="no_anggota"
                placeholder="Contoh: A001"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

        </div>


        <div class="mb-5">

            <label
                for="nama"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Nama

            </label>

            <input
                type="text"
                id="nama"
                name="nama"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

        </div>


        <div class="mb-5">

            <label
                for="alamat"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Alamat

            </label>

            <textarea
                id="alamat"
                name="alamat"
                rows="4"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"></textarea>

        </div>


        <div class="mb-6">

            <label
                for="no_hp"
                class="block text-sm font-semibold text-slate-700 mb-2">

                No. HP

            </label>

            <input
                type="text"
                id="no_hp"
                name="no_hp"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">

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

                Simpan Anggota

            </button>

        </div>

    </form>

</section>


<?php

include __DIR__ . '/../includes/footer.php';

?>