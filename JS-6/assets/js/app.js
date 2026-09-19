function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.getElementById("main-nav");

    if (!toggleBtn || !nav) {
        return;
    }

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("hidden");

        if (nav.classList.contains("hidden")) {
            toggleBtn.setAttribute("aria-expanded", "false");
        } else {
            toggleBtn.setAttribute("aria-expanded", "true");
        }
    });
}


function initTableFilter() {
    const searchInput = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");

    if (!searchInput || !table) {
        return;
    }

    searchInput.addEventListener("keyup", function () {
        const keyword = searchInput.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            const text = row.textContent.toLowerCase();

            if (text.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
}


function initHapusConfirm() {
    document.addEventListener("click", function (event) {
        const button = event.target.closest(".btn-hapus");

        if (!button) {
            return;
        }

        const row = button.closest("tr");

        if (!row) {
            return;
        }

        const cells = row.querySelectorAll("td");

        let namaData = "data ini";

        if (cells.length > 1) {
            namaData = cells[1].textContent.trim();
        }

        const yakin = confirm(
            'Yakin ingin menghapus "' + namaData + '"?'
        );

        if (yakin) {
            row.remove();
        }
    });
}


function tampilkanError(input, pesan) {
    hapusError(input);

    const error = document.createElement("small");

    error.className =
        "js-error block mt-2 text-sm font-medium text-red-600";

    error.textContent = pesan;

    input.insertAdjacentElement("afterend", error);

    input.classList.remove("border-slate-300");
    input.classList.add("border-red-500");
}


function hapusError(input) {
    const next = input.nextElementSibling;

    if (next && next.classList.contains("js-error")) {
        next.remove();
    }

    input.classList.remove("border-red-500");
    input.classList.add("border-slate-300");
}


function initValidasiForm() {
    const form =
        document.getElementById("form-tambah") ||
        document.getElementById("form-anggota");

    if (!form) {
        return;
    }

    form.addEventListener("submit", function (event) {
        let valid = true;

        const fieldWajib = [
            "judul",
            "penulis",
            "penerbit",
            "kategori",
            "noAnggota",
            "nama",
            "alamat",
            "noHp"
        ];

        fieldWajib.forEach(function (namaField) {
            const input = form.querySelector(
                '[name="' + namaField + '"]'
            );

            if (!input) {
                return;
            }

            if (input.value.trim() === "") {
                tampilkanError(
                    input,
                    "Field ini wajib diisi."
                );

                valid = false;
            } else {
                hapusError(input);
            }
        });


        const tahun = form.querySelector('[name="tahun"]');

        if (tahun) {
            const nilaiTahun = parseInt(tahun.value, 10);

            if (
                isNaN(nilaiTahun) ||
                nilaiTahun < 1900 ||
                nilaiTahun > 2026
            ) {
                tampilkanError(
                    tahun,
                    "Tahun harus antara 1900 - 2026."
                );

                valid = false;
            } else {
                hapusError(tahun);
            }
        }


        const stok = form.querySelector('[name="stok"]');

        if (stok) {
            const nilaiStok = parseInt(stok.value, 10);

            if (
                stok.value.trim() === "" ||
                isNaN(nilaiStok)
            ) {
                tampilkanError(
                    stok,
                    "Stok wajib diisi."
                );

                valid = false;
            } else if (nilaiStok < 0) {
                tampilkanError(
                    stok,
                    "Stok tidak boleh negatif."
                );

                valid = false;
            } else {
                hapusError(stok);
            }
        }


        if (!valid) {
            event.preventDefault();
        }
    });
}


document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initTableFilter();
    initHapusConfirm();
    initValidasiForm();
});