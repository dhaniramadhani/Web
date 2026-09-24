function formatTanggalInput(date) {
    const tahun =
        date.getFullYear();

    const bulan =
        String(
            date.getMonth() + 1
        ).padStart(2, "0");

    const tanggal =
        String(
            date.getDate()
        ).padStart(2, "0");

    return (
        tahun +
        "-" +
        bulan +
        "-" +
        tanggal
    );
}


function initTanggalPeminjaman() {
    const tanggalPinjam =
        document.getElementById(
            "tanggal-pinjam"
        );

    const tanggalKembali =
        document.getElementById(
            "tanggal-kembali"
        );


    if (
        !tanggalPinjam ||
        !tanggalKembali
    ) {
        return;
    }


    const hariIni =
        new Date();


    if (
        tanggalPinjam.value === ""
    ) {

        tanggalPinjam.value =
            formatTanggalInput(
                hariIni
            );
    }


    const tujuhHari =
        new Date();

    tujuhHari.setDate(
        tujuhHari.getDate() + 7
    );


    if (
        tanggalKembali.value === ""
    ) {

        tanggalKembali.value =
            formatTanggalInput(
                tujuhHari
            );
    }


    tanggalKembali.min =
        tanggalPinjam.value;


    tanggalPinjam.addEventListener(
        "change",
        function () {

            tanggalKembali.min =
                tanggalPinjam.value;


            if (
                tanggalKembali.value <
                tanggalPinjam.value
            ) {

                const tanggalBaru =
                    new Date(
                        tanggalPinjam.value +
                        "T00:00:00"
                    );


                tanggalBaru.setDate(
                    tanggalBaru.getDate() + 7
                );


                tanggalKembali.value =
                    formatTanggalInput(
                        tanggalBaru
                    );
            }
        }
    );
}


function initKonfirmasiPengembalian() {
    const forms =
        document.querySelectorAll(
            ".form-pengembalian"
        );


    forms.forEach(
        function (form) {

            form.addEventListener(
                "submit",
                function (event) {

                    const yakin =
                        confirm(
                            "Yakin buku sudah dikembalikan?"
                        );


                    if (!yakin) {
                        event.preventDefault();
                    }
                }
            );
        }
    );
}


document.addEventListener(
    "DOMContentLoaded",
    function () {

        initTanggalPeminjaman();

        initKonfirmasiPengembalian();

    }
);