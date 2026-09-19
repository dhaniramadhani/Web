async function muatRingkasanDashboard() {
    const totalBuku =
        document.getElementById("total-buku");

    const totalAnggota =
        document.getElementById("total-anggota");

    const totalDipinjam =
        document.getElementById("total-dipinjam");

    if (
        !totalBuku ||
        !totalAnggota ||
        !totalDipinjam
    ) {
        return;
    }

    try {
        const hasil = await Promise.all([
            fetch("data/buku.json"),
            fetch("data/anggota.json")
        ]);

        const responseBuku = hasil[0];
        const responseAnggota = hasil[1];

        if (
            !responseBuku.ok ||
            !responseAnggota.ok
        ) {
            throw new Error("Gagal mengambil data.");
        }

        const buku = await responseBuku.json();
        const anggota = await responseAnggota.json();

        totalBuku.textContent = buku.length;
        totalAnggota.textContent = anggota.length;

    } catch (error) {
        totalBuku.textContent = "-";
        totalAnggota.textContent = "-";
    }


    let transaksi = [];

    try {
        transaksi =
            JSON.parse(
                localStorage.getItem(
                    "simpus-transaksi"
                )
            ) || [];
    } catch (error) {
        transaksi = [];
    }

    const sedangDipinjam =
        transaksi.filter(function (item) {
            return item.status === "Dipinjam";
        });

    totalDipinjam.textContent =
        sedangDipinjam.length;
}


document.addEventListener(
    "DOMContentLoaded",
    muatRingkasanDashboard
);