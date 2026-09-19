async function muatDaftarAnggota() {
    const tbody =
        document.getElementById("data-anggota");

    const loading =
        document.getElementById("loading-indicator");

    if (!tbody || !loading) {
        return;
    }

    loading.classList.remove("hidden");
    tbody.innerHTML = "";

    try {
        await new Promise(function (resolve) {
            setTimeout(resolve, 600);
        });

        const response =
            await fetch("../data/anggota.json");

        if (!response.ok) {
            throw new Error(
                "Gagal mengambil data. Status: " +
                response.status
            );
        }

        const daftarAnggota =
            await response.json();

        daftarAnggota.forEach(function (anggota) {
            const row =
                document.createElement("tr");

            row.className =
                "hover:bg-slate-50 transition";

            row.innerHTML = `
                <td class="px-5 py-4 text-slate-600">
                    ${anggota.no_anggota}
                </td>

                <td class="px-5 py-4 font-semibold text-slate-800">
                    ${anggota.nama}
                </td>

                <td class="px-5 py-4 text-slate-600">
                    ${anggota.alamat}
                </td>

                <td class="px-5 py-4 text-slate-600">
                    ${anggota.no_hp}
                </td>

                <td class="px-5 py-4">

                    <div class="flex gap-2">

                        <button
                            type="button"
                            class="bg-sky-50 hover:bg-sky-100 text-sky-700 text-sm font-medium px-3 py-2 rounded-lg">
                            Edit
                        </button>

                        <button
                            type="button"
                            class="btn-hapus bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-3 py-2 rounded-lg">
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
                    colspan="5"
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
    muatDaftarAnggota
);