const KUNCI_TRANSAKSI = "simpus-transaksi";

function ambilTransaksi() {
    try {
        const data =
            JSON.parse(
                localStorage.getItem(KUNCI_TRANSAKSI)
            );

        if (Array.isArray(data)) {
            return data;
        }

        return [];
    } catch (error) {
        return [];
    }
}


function simpanTransaksi(data) {
    localStorage.setItem(
        KUNCI_TRANSAKSI,
        JSON.stringify(data)
    );
}


function tanggalLokal(date = new Date()) {
    const tahun = date.getFullYear();

    const bulan =
        String(date.getMonth() + 1)
            .padStart(2, "0");

    const hari =
        String(date.getDate())
            .padStart(2, "0");

    return tahun + "-" + bulan + "-" + hari;
}


function tambahHari(tanggal, jumlahHari) {
    const date =
        new Date(tanggal + "T00:00:00");

    date.setDate(
        date.getDate() + jumlahHari
    );

    return tanggalLokal(date);
}


function formatTanggal(tanggal) {
    if (!tanggal) {
        return "-";
    }

    const bagian = tanggal.split("-");

    if (bagian.length !== 3) {
        return tanggal;
    }

    return (
        bagian[2] +
        "-" +
        bagian[1] +
        "-" +
        bagian[0]
    );
}


function tampilkanPesan(
    element,
    pesan,
    tipe
) {
    if (!element) {
        return;
    }

    element.textContent = pesan;

    if (tipe === "sukses") {
        element.className =
            "mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700";
    } else {
        element.className =
            "mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600";
    }

    element.classList.remove("hidden");
}



/* =========================
   PEMINJAMAN
========================= */

async function initPeminjaman() {
    const form =
        document.getElementById("form-peminjaman");

    if (!form) {
        return;
    }

    const pilihAnggota =
        document.getElementById("pilih-anggota");

    const pilihBuku =
        document.getElementById("pilih-buku");

    const tanggalPinjam =
        document.getElementById("tanggal-pinjam");

    const tanggalKembali =
        document.getElementById("tanggal-kembali");

    const loading =
        document.getElementById("loading-peminjaman");

    const pesan =
        document.getElementById("pesan-peminjaman");


    const hariIni = tanggalLokal();

    tanggalPinjam.value = hariIni;
    tanggalPinjam.min = hariIni;

    tanggalKembali.value =
        tambahHari(hariIni, 7);

    tanggalKembali.min = hariIni;


    tanggalPinjam.addEventListener(
        "change",
        function () {
            if (!tanggalPinjam.value) {
                return;
            }

            tanggalKembali.min =
                tanggalPinjam.value;

            if (
                !tanggalKembali.value ||
                tanggalKembali.value <
                tanggalPinjam.value
            ) {
                tanggalKembali.value =
                    tambahHari(
                        tanggalPinjam.value,
                        7
                    );
            }
        }
    );


    loading.classList.remove("hidden");

    try {
        const hasil =
            await Promise.all([
                fetch("data/anggota.json"),
                fetch("data/buku.json")
            ]);

        const responseAnggota = hasil[0];
        const responseBuku = hasil[1];

        if (
            !responseAnggota.ok ||
            !responseBuku.ok
        ) {
            throw new Error(
                "Data tidak dapat dimuat."
            );
        }

        const daftarAnggota =
            await responseAnggota.json();

        const daftarBuku =
            await responseBuku.json();


        daftarAnggota.forEach(
            function (anggota) {
                const option =
                    document.createElement(
                        "option"
                    );

                option.value =
                    anggota.no_anggota;

                option.textContent =
                    anggota.no_anggota +
                    " - " +
                    anggota.nama;

                option.dataset.nama =
                    anggota.nama;

                pilihAnggota.appendChild(
                    option
                );
            }
        );


        daftarBuku.forEach(
            function (buku) {
                const option =
                    document.createElement(
                        "option"
                    );

                option.value =
                    buku.judul;

                option.dataset.judul =
                    buku.judul;

                if (buku.stok <= 0) {
                    option.disabled = true;

                    option.textContent =
                        buku.judul +
                        " (stok habis)";
                } else {
                    option.textContent =
                        buku.judul +
                        " - stok " +
                        buku.stok;
                }

                pilihBuku.appendChild(
                    option
                );
            }
        );

    } catch (error) {

        tampilkanPesan(
            pesan,
            "Gagal memuat data anggota atau buku.",
            "error"
        );

    } finally {
        loading.classList.add("hidden");
    }


    form.addEventListener(
        "submit",
        function (event) {
            event.preventDefault();

            pesan.classList.add("hidden");


            if (
                pilihAnggota.value === "" ||
                pilihBuku.value === "" ||
                tanggalPinjam.value === "" ||
                tanggalKembali.value === ""
            ) {
                tampilkanPesan(
                    pesan,
                    "Semua data peminjaman wajib diisi.",
                    "error"
                );

                return;
            }


            if (
                tanggalKembali.value <
                tanggalPinjam.value
            ) {
                tampilkanPesan(
                    pesan,
                    "Tanggal kembali tidak boleh sebelum tanggal pinjam.",
                    "error"
                );

                return;
            }


            const optionAnggota =
                pilihAnggota.options[
                    pilihAnggota.selectedIndex
                ];


            const transaksi =
                ambilTransaksi();


            const dataBaru = {
                id:
                    "PJM-" +
                    Date.now(),

                no_anggota:
                    pilihAnggota.value,

                nama_anggota:
                    optionAnggota.dataset.nama,

                buku:
                    pilihBuku.value,

                tanggal_pinjam:
                    tanggalPinjam.value,

                tanggal_kembali:
                    tanggalKembali.value,

                tanggal_dikembalikan:
                    "",

                status:
                    "Dipinjam"
            };


            transaksi.push(dataBaru);

            simpanTransaksi(transaksi);


            tampilkanPesan(
                pesan,
                "Peminjaman berhasil disimpan.",
                "sukses"
            );


            setTimeout(function () {
                window.location.href =
                    "riwayat.html";
            }, 700);
        }
    );
}



/* =========================
   PENGEMBALIAN
========================= */

function initPengembalian() {
    const cari =
        document.getElementById(
            "cari-peminjaman"
        );

    if (!cari) {
        return;
    }

    const hasil =
        document.getElementById(
            "hasil-pencarian"
        );

    const detail =
        document.getElementById(
            "detail-peminjaman"
        );

    const pesan =
        document.getElementById(
            "pesan-pengembalian"
        );

    const btnKonfirmasi =
        document.getElementById(
            "btn-konfirmasi-kembali"
        );

    let idTerpilih = null;


    function renderHasil(keyword = "") {
        const transaksi =
            ambilTransaksi();

        const kata =
            keyword
                .trim()
                .toLowerCase();


        const aktif =
            transaksi.filter(
                function (item) {
                    if (
                        item.status !==
                        "Dipinjam"
                    ) {
                        return false;
                    }

                    const gabungan =
                        (
                            item.id +
                            " " +
                            item.no_anggota +
                            " " +
                            item.nama_anggota +
                            " " +
                            item.buku
                        ).toLowerCase();

                    return gabungan.includes(
                        kata
                    );
                }
            );


        if (aktif.length === 0) {
            hasil.innerHTML = `
                <div class="rounded-xl border border-slate-200 bg-white p-5 text-sm text-slate-500">
                    Tidak ada peminjaman aktif yang ditemukan.
                </div>
            `;

            return;
        }


        hasil.innerHTML = "";

        aktif.forEach(function (item) {
            const card =
                document.createElement(
                    "div"
                );

            card.className =
                "bg-white border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4";

            card.innerHTML = `
                <div>
                    <p class="font-semibold text-slate-800">
                        ${item.nama_anggota}
                    </p>

                    <p class="text-sm text-slate-500 mt-1">
                        ${item.id} • ${item.buku}
                    </p>
                </div>

                <button
                    type="button"
                    data-id="${item.id}"
                    class="btn-pilih-pinjaman bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-medium px-4 py-2 rounded-lg">
                    Pilih
                </button>
            `;

            hasil.appendChild(card);
        });
    }


    function tampilkanDetail(id) {
        const transaksi =
            ambilTransaksi();

        const item =
            transaksi.find(
                function (data) {
                    return data.id === id;
                }
            );

        if (!item) {
            return;
        }

        idTerpilih = id;

        document.getElementById(
            "detail-id"
        ).textContent = item.id;

        document.getElementById(
            "detail-anggota"
        ).textContent =
            item.no_anggota +
            " - " +
            item.nama_anggota;

        document.getElementById(
            "detail-buku"
        ).textContent =
            item.buku;

        document.getElementById(
            "detail-pinjam"
        ).textContent =
            formatTanggal(
                item.tanggal_pinjam
            );

        document.getElementById(
            "detail-kembali"
        ).textContent =
            formatTanggal(
                item.tanggal_kembali
            );

        document.getElementById(
            "detail-status"
        ).textContent =
            item.status;

        detail.classList.remove(
            "hidden"
        );
    }


    hasil.addEventListener(
        "click",
        function (event) {
            const button =
                event.target.closest(
                    ".btn-pilih-pinjaman"
                );

            if (!button) {
                return;
            }

            tampilkanDetail(
                button.dataset.id
            );
        }
    );


    cari.addEventListener(
        "input",
        function () {
            renderHasil(
                cari.value
            );
        }
    );


    btnKonfirmasi.addEventListener(
        "click",
        function () {
            if (!idTerpilih) {
                return;
            }

            const yakin = confirm(
                "Yakin buku sudah dikembalikan?"
            );

            if (!yakin) {
                return;
            }

            const transaksi =
                ambilTransaksi();

            const index =
                transaksi.findIndex(
                    function (item) {
                        return (
                            item.id ===
                            idTerpilih
                        );
                    }
                );

            if (index === -1) {
                return;
            }


            transaksi[index].status =
                "Dikembalikan";

            transaksi[index]
                .tanggal_dikembalikan =
                tanggalLokal();


            simpanTransaksi(transaksi);

            tampilkanPesan(
                pesan,
                "Pengembalian berhasil dikonfirmasi.",
                "sukses"
            );

            detail.classList.add(
                "hidden"
            );

            idTerpilih = null;

            renderHasil(cari.value);
        }
    );


    renderHasil();
}



/* =========================
   RIWAYAT
========================= */

function initRiwayat() {
    const tbody =
        document.getElementById(
            "data-riwayat"
        );

    if (!tbody) {
        return;
    }

    const cari =
        document.getElementById(
            "search-riwayat"
        );

    const detail =
        document.getElementById(
            "detail-riwayat"
        );


    function render(keyword = "") {
        const kata =
            keyword
                .trim()
                .toLowerCase();

        const transaksi =
            ambilTransaksi()
                .slice()
                .reverse()
                .filter(
                    function (item) {
                        const gabungan =
                            (
                                item.id +
                                " " +
                                item.no_anggota +
                                " " +
                                item.nama_anggota +
                                " " +
                                item.buku +
                                " " +
                                item.status
                            ).toLowerCase();

                        return gabungan.includes(
                            kata
                        );
                    }
                );


        if (
            transaksi.length === 0
        ) {
            tbody.innerHTML = `
                <tr>
                    <td
                        colspan="6"
                        class="px-5 py-8 text-center text-slate-500">
                        Belum ada transaksi yang ditemukan.
                    </td>
                </tr>
            `;

            return;
        }


        tbody.innerHTML = "";

        transaksi.forEach(
            function (item, index) {
                const row =
                    document.createElement(
                        "tr"
                    );

                row.dataset.id =
                    item.id;

                row.className =
                    "cursor-pointer hover:bg-slate-50 transition";


                let statusClass =
                    "bg-amber-50 text-amber-700";

                if (
                    item.status ===
                    "Dikembalikan"
                ) {
                    statusClass =
                        "bg-emerald-50 text-emerald-700";
                }


                row.innerHTML = `
                    <td class="px-5 py-4">
                        ${index + 1}
                    </td>

                    <td class="px-5 py-4">
                        <p class="font-medium">
                            ${item.no_anggota}
                        </p>

                        <p class="text-xs text-slate-500">
                            ${item.nama_anggota}
                        </p>
                    </td>

                    <td class="px-5 py-4">
                        ${item.buku}
                    </td>

                    <td class="px-5 py-4">
                        ${formatTanggal(item.tanggal_pinjam)}
                    </td>

                    <td class="px-5 py-4">
                        ${formatTanggal(item.tanggal_kembali)}
                    </td>

                    <td class="px-5 py-4">
                        <span
                            class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ${statusClass}">
                            ${item.status}
                        </span>
                    </td>
                `;

                tbody.appendChild(row);
            }
        );
    }


    function tampilkanDetailRiwayat(id) {
        const transaksi =
            ambilTransaksi();

        const item =
            transaksi.find(
                function (data) {
                    return data.id === id;
                }
            );

        if (!item) {
            return;
        }


        document.getElementById(
            "riwayat-id"
        ).textContent = item.id;

        document.getElementById(
            "riwayat-anggota"
        ).textContent =
            item.no_anggota +
            " - " +
            item.nama_anggota;

        document.getElementById(
            "riwayat-buku"
        ).textContent =
            item.buku;

        document.getElementById(
            "riwayat-pinjam"
        ).textContent =
            formatTanggal(
                item.tanggal_pinjam
            );

        document.getElementById(
            "riwayat-rencana-kembali"
        ).textContent =
            formatTanggal(
                item.tanggal_kembali
            );

        document.getElementById(
            "riwayat-dikembalikan"
        ).textContent =
            formatTanggal(
                item.tanggal_dikembalikan
            );

        document.getElementById(
            "riwayat-status"
        ).textContent =
            item.status;

        detail.classList.remove(
            "hidden"
        );
    }


    cari.addEventListener(
        "input",
        function () {
            render(cari.value);
        }
    );


    tbody.addEventListener(
        "click",
        function (event) {
            const row =
                event.target.closest(
                    "tr[data-id]"
                );

            if (!row) {
                return;
            }

            tampilkanDetailRiwayat(
                row.dataset.id
            );
        }
    );


    render();
}


document.addEventListener(
    "DOMContentLoaded",
    function () {
        initPeminjaman();
        initPengembalian();
        initRiwayat();
    }
);