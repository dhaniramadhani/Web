<?php

$page_title =
    "Riwayat Peminjaman";

include __DIR__ .
    '/includes/header.php';


$flash =
    $_SESSION['flash_transaksi']
    ?? null;

unset(
    $_SESSION['flash_transaksi']
);


$daftarTransaksi =
    $_SESSION['transaksi'] ?? [];

$daftarTransaksi =
    array_reverse(
        $daftarTransaksi
    );

?>


<section>


    <div class="mb-6">

        <p class="text-sm font-medium text-indigo-600 mb-1">
            Transaksi
        </p>

        <h2 class="text-2xl md:text-3xl font-bold">
            Riwayat Peminjaman
        </h2>

        <p class="text-slate-500 mt-2">
            Seluruh riwayat peminjaman dan
            pengembalian buku.
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


    <div class="mb-6">

        <label
            for="search-input"
            class="block text-sm font-semibold text-slate-700 mb-2">

            Cari Riwayat

        </label>

        <input
            type="text"
            id="search-input"
            placeholder="Cari anggota, buku, atau status..."
            class="w-full max-w-md bg-white border border-slate-300 rounded-xl px-4 py-3">

    </div>


    <div class="table-responsive overflow-x-auto bg-white border border-slate-200 rounded-2xl shadow-sm">


        <table class="w-full min-w-[950px]">


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
                        Dikembalikan
                    </th>

                    <th class="text-left px-5 py-4">
                        Status
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">


            <?php if (
                empty($daftarTransaksi)
            ): ?>

                <tr>

                    <td
                        colspan="7"
                        class="px-5 py-8 text-center text-slate-500">

                        Belum ada riwayat transaksi.

                    </td>

                </tr>


            <?php else: ?>


                <?php foreach (
                    $daftarTransaksi
                    as $transaksi
                ): ?>


                    <tr class="hover:bg-slate-50">


                        <td class="px-5 py-4">

                            <?php
                            echo htmlspecialchars(
                                $transaksi['id']
                            );
                            ?>

                        </td>


                        <td class="px-5 py-4">

                            <p class="font-medium">

                                <?php
                                echo htmlspecialchars(
                                    $transaksi[
                                        'nama_anggota'
                                    ]
                                );
                                ?>

                            </p>

                            <p class="text-xs text-slate-500">

                                <?php
                                echo htmlspecialchars(
                                    $transaksi[
                                        'no_anggota'
                                    ]
                                );
                                ?>

                            </p>

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
                                $transaksi[
                                    'tanggal_pinjam'
                                ]
                            );
                            ?>

                        </td>


                        <td class="px-5 py-4">

                            <?php
                            echo htmlspecialchars(
                                $transaksi[
                                    'tanggal_kembali'
                                ]
                            );
                            ?>

                        </td>


                        <td class="px-5 py-4">

                            <?php

                            if (
                                empty(
                                    $transaksi[
                                        'tanggal_dikembalikan'
                                    ]
                                )
                            ) {

                                echo '-';

                            } else {

                                echo htmlspecialchars(
                                    $transaksi[
                                        'tanggal_dikembalikan'
                                    ]
                                );
                            }

                            ?>

                        </td>


                        <td class="px-5 py-4">


                            <?php if (
                                $transaksi['status'] ===
                                'Dipinjam'
                            ): ?>

                                <span class="inline-flex bg-amber-50 text-amber-700 px-3 py-1 rounded-full text-xs font-semibold">

                                    Dipinjam

                                </span>


                            <?php else: ?>

                                <span class="inline-flex bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">

                                    Dikembalikan

                                </span>

                            <?php endif; ?>


                        </td>


                    </tr>


                <?php endforeach; ?>


            <?php endif; ?>


            </tbody>

        </table>

    </div>

</section>


<?php

include __DIR__ .
    '/includes/footer.php';

?>