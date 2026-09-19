async function muatDaftarBuku() {
    const tbody = document.getElementById("data-buku");
    const loading = document.getElementById("loading-indicator");

    if (!tbody || !loading) {
        return;
    }

    loading.classList.remove("hidden");
    tbody.innerHTML = "";

    try {
        await new Promise(function (resolve) {
            setTimeout(resolve, 600);
        });

        const response = await fetch("../data/buku.json");

        if (!response.ok) {
            throw new Error(
                "Gagal mengambil data. Status: " + response.status
            );
        }

        const daftarBuku = await response.json();

        daftarBuku.forEach(function (buku, index) {
            const row = document.createElement("tr");

            row.className = "hover:bg-slate-50";

            row.innerHTML = `
                <td class="px-5 py-4">
                    ${index + 1}
                </td>

                <td class="px-5 py-4 font-medium">
                    ${buku.judul}
                </td>

                <td class="px-5 py-4">
                    ${buku.pengarang}
                </td>

                <td class="px-5 py-4">
                    ${buku.tahun}
                </td>

                <td class="px-5 py-4">
                    ${buku.stok}
                </td>

                <td class="px-5 py-4">
                    <div class="flex gap-2">

                        <button
                            type="button"
                            class="bg-sky-500 hover:bg-sky-600 text-white text-sm px-3 py-2 rounded-lg">
                            Edit
                        </button>

                        <button
                            type="button"
                            class="btn-hapus bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-2 rounded-lg">
                            Hapus
                        </button>

                    </div>
                </td>
            `;

            tbody.appendChild(row);
        });

    } catch (error) {

        tbody.innerHTML = `
            <tr>
                <td
                    colspan="6"
                    class="px-5 py-6 text-center text-red-600">
                    Gagal memuat data: ${error.message}
                </td>
            </tr>
        `;

    } finally {

        loading.classList.add("hidden");

    }
}

document.addEventListener(
    "DOMContentLoaded",
    muatDaftarBuku
);