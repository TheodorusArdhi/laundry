
window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    datatablesSimple.style.fontSize = "16px";

    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple, {
            labels: {
                placeholder: "Cari...",
                searchTitle: "Cari dalam tabel",
                pageTitle: "Halaman {page}",
                perPage: "Masukan per halaman",
                noRows: "Data tidak ditemukan",
                info: "Menampilkan {start} hingga {end} dari {rows} masukan",
                noResults: "Hasil pencarian tidak ditemukan",
            }
        });
        
    }

    const datatablesSimple2 = document.getElementById('datatablesSimple2');
    datatablesSimple2.style.fontSize = "16px";

    if (datatablesSimple2) {
        new simpleDatatables.DataTable(datatablesSimple2, {
            labels: {
                placeholder: "Cari...",
                searchTitle: "Cari dalam tabel",
                pageTitle: "Halaman {page}",
                perPage: "Masukan per halaman",
                noRows: "Data tidak ditemukan",
                info: "Menampilkan {start} hingga {end} dari {rows} masukan",
                noResults: "Hasil pencarian tidak ditemukan",
            }
        });
        
    }
    
});
