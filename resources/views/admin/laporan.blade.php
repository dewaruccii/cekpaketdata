<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Paket</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.5/css/dataTables.tailwindcss.css">

    <style>
        /* [Kode CSS OVERRIDE Light Mode sebelumnya tetap sama untuk pagination, search, dan baris] */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .data-table {
            width: 100% !important;
        }

        /* --- OVERRIDE UTAMA DATATABLES UNTUK LIGHT MODE --- */

        /* 1. OVERRIDE INPUT FIELD (Search dan Length Control) */
        div.dt-container .dt-input,
        div.dt-container .dt-search input,
        div.dt-container .dt-length select {
            color: #1f2937 !important;
            background-color: #ffffff !important;
            border-color: #d1d5db !important;
        }

        /* 2. OVERRIDE TEKS INFO DAN LENGTH LABEL */
        div.dt-container .dt-info,
        div.dt-container .dt-length label {
            color: #374151 !important;
        }

        /* 3. OVERRIDE PAGINATION BUTTONS */
        div.dt-container .dt-paging .dt-paging-button {
            color: #4b5563 !important;
            background-color: #ffffff !important;
            border: 1px solid #d1d5db !important;
        }

        /* Pagination Current/Hover State */
        div.dt-container .dt-paging .dt-paging-button.current,
        div.dt-container .dt-paging .dt-paging-button:hover {
            background-color: #e0e7ff !important;
            color: #3730a3 !important;
            border-color: #6366f1 !important;
        }

        /* 4. OVERRIDE PAGINATION DISABLED BUTTONS */
        div.dt-container .dt-paging .dt-paging-button.disabled {
            background-color: #f3f4f6 !important;
            color: #9ca3af !important;
            cursor: not-allowed !important;
            opacity: 1 !important;
        }

        /* OVERRIDE BARIS DAN HEADER */
        table.dataTable tbody tr {
            background-color: #ffffff !important;
            color: #374151 !important;
        }

        table.dataTable thead th {
            background-color: #f9fafb !important;
            color: #1f2937 !important;
        }

        /* Hover dan Striping Kustom */
        .data-row:hover {
            background-color: #eef2ff !important;
            transition: background-color 0.15s;
        }

        .data-row-odd {
            background-color: #ffffff !important;
        }

        .data-row-even {
            background-color: #f9fafb !important;
        }

        /* Menghilangkan fokus outline bawaan DataTables dengan focus ring Tailwind */
        div.dt-container .dt-search input:focus,
        div.dt-container .dt-length select:focus,
        div.dt-container .dt-paging button:focus {
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5) !important;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }
    </style>
</head>

<body class="p-4 sm:p-8">

    <div class="max-w-7xl mx-auto">

        <header class="mb-6 bg-white p-6 rounded-xl shadow-lg">
            <button onclick="history.back()"
                class="flex items-center text-indigo-600 hover:text-indigo-800 transition duration-150 p-2 -ml-2 mb-4 rounded-lg hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="text-sm font-medium">Kembali</span>
            </button>

            <h1 class="text-3xl font-extrabold text-gray-900">
                Laporan Seluruh Data Paket
            </h1>
            <p class="mt-2 text-gray-500">
                Ringkasan dari data paket yang telah dimasukkan, termasuk detail teknis dan lampiran.
            </p>
            <p id="loading-message" class="mt-4 text-sm text-indigo-600 font-medium">
                Mengambil data laporan dan lokasi kabupaten... Mohon tunggu sebentar.
            </p>
            <p id="error-message" class="mt-4 text-sm text-red-600 font-medium hidden">
                ⚠️ Gagal memuat data laporan! Silakan coba lagi nanti.
            </p>
        </header>

        <div class="bg-white rounded-xl shadow-lg p-0 table-wrapper p-2" style="overflow-x:hidden">
            <table class="w-full text-sm text-left text-gray-700 data-table" id="reportTable">

                <thead class="text-xs text-gray-800 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 rounded-tl-xl">No</th>
                        <th scope="col" class="px-6 py-3">Operator</th>
                        <th scope="col" class="px-6 py-3 text-center">Harga (IDR)</th>
                        <th scope="col" class="px-6 py-3 text-center">Kuota (GB)</th>
                        <th scope="col" class="px-6 py-3 text-center">Masa Aktif (Hari)</th>
                        <th scope="col" class="px-6 py-3 text-center">PPGB</th>
                        <th scope="col" class="px-6 py-3 text-center">Flag</th>
                        <th scope="col" class="px-6 py-3">Lokasi (Kabupaten)</th>
                        <th scope="col" class="px-6 py-3">Email Pengguna</th>
                        <th scope="col" class="px-6 py-3 rounded-tr-xl text-center">Lampiran File</th>
                    </tr>
                </thead>
                <tbody id="reportTableBody">
                </tbody>
            </table>
        </div>

    </div>

    <div id="fileModal" class="modal-overlay hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 transform transition duration-300">
            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Lampiran File</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div id="modalFileList" class="py-4 space-y-2">
            </div>

            <div class="pt-3 border-t border-gray-200 text-right">
                <button onclick="closeModal()"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.tailwindcss.js"></script>

    <script>
        // *** GANTI DENGAN URL API ANDA YANG SEBENARNYA ***
        const API_ENDPOINT = '{{ route('admin.laporan.data') }}';
        // Contoh API: 'https://api.example.com/reports/package_data'
        // API harus mengembalikan array objek dengan struktur yang sama seperti mockDataReports sebelumnya.

        // --- FUNGSI BARU UNTUK MENGAMBIL DATA DARI API ---
        /**
         * Mengambil data laporan paket dari endpoint API.
         * @returns {Promise<Array<Object>>} Array berisi data laporan, atau array kosong jika gagal.
         */
        async function fetchDataFromAPI() {
            const errorMessage = document.getElementById('error-message');
            errorMessage.classList.add('hidden'); // Sembunyikan pesan error

            try {
                const response = await fetch(API_ENDPOINT);

                if (!response.ok) {
                    throw new Error(`Gagal memuat data API: ${response.status} ${response.statusText}`);
                }

                const data = await response.json();

                // Asumsi API mengembalikan array data laporan
                if (Array.isArray(data.data)) {
                    return data.data;
                } else {
                    console.error("API Error: Data yang dikembalikan bukan array", data.data);
                    throw new Error("Format data API tidak valid.");
                }

            } catch (error) {
                console.error("Fetch Data Error:", error);
                // Tampilkan pesan error di UI
                errorMessage.textContent = `⚠️ Gagal memuat data laporan: ${error.message}`;
                errorMessage.classList.remove('hidden');
                return []; // Kembalikan array kosong jika terjadi kesalahan
            }
        }


        // --- FUNGSI REVERSE GEOCODING MENGGUNAKAN NOMINATIM (OSM) ---
        /**
         * Mengambil nama kabupaten/kota dari koordinat menggunakan Nominatim API.
         * @param {number} lat - Latitude
         * @param {number} lon - Longitude
         * @returns {Promise<string>} Nama kabupaten/kota atau pesan error.
         */
        async function getKabupatenFromCoords(lat, lon) {
            // zoom=10 biasanya cukup untuk mendapatkan detail tingkat kota/kabupaten
            const nominatimUrl =
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=10&addressdetails=1`;

            try {
                const response = await fetch(nominatimUrl, {
                    // PENTING: User-Agent diperlukan oleh Nominatim untuk identifikasi
                    headers: {
                        'User-Agent': 'DataTablesGeocodingExample/1.0 (contact@your-domain.com)'
                    }
                });

                if (!response.ok) {
                    // Nominatim sering membatasi laju, jadi berikan pesan yang jelas
                    throw new Error(
                        `Gagal memuat API Nominatim! Batas laju mungkin tercapai. Status: ${response.status}`);
                }

                const data = await response.json();

                if (data.address) {
                    const address = data.address;
                    // Prioritas: city, town, county (setara kabupaten di beberapa negara), state_district, village
                    return address.city || address.town || address.county || address.state_district || address
                        .village || 'Kabupaten Tidak Ditemukan';
                }
                return 'Alamat Tidak Ditemukan';

            } catch (error) {
                console.error("Geocoding Error:", error);
                return `Gagal GeoCode: ${error.message}`;
            }
        }

        // --- FUNGSI MODAL (TETAP SAMA) ---
        function openModal(files) {
            const modal = document.getElementById('fileModal');
            const fileList = document.getElementById('modalFileList');
            fileList.innerHTML = '';

            // Penanganan jika files tidak ada atau kosong
            if (!files || files.length === 0) {
                fileList.innerHTML = '<p class="text-gray-500 text-center">Tidak ada file lampiran untuk laporan ini.</p>';
            } else {
                files.forEach(file => {
                    // Mengubah dari div menjadi elemen <a> untuk redirect
                    const fileLink = document.createElement('a');

                    // Mengatur atribut link
                    fileLink.href = file.file_url; // Menggunakan URL file sebagai href
                    fileLink.target = '_blank'; // Membuka di tab baru
                    fileLink.title = file.file_name; // Tambahkan title untuk aksesibilitas

                    // Kelas yang sama, diterapkan ke tag <a>
                    fileLink.className =
                        'flex items-center space-x-2 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-100 cursor-pointer text-decoration-none';

                    // Menambahkan event listener untuk menutup modal saat tautan diklik
                    fileLink.onclick = () => {
                        // Tutup modal agar tidak mengganggu tab baru yang dibuka
                        closeModal();
                    };

                    // Konten HTML
                    fileLink.innerHTML = `
                <svg class="w-5 h-5 text-indigo-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13.5" /></svg>
                <span class="text-sm font-medium text-gray-700 truncate">${file.file_name}</span>
            `;

                    fileList.appendChild(fileLink);
                });
            }
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('fileModal').classList.add('hidden');
        }

        // --- FUNGSI UTAMA ASINKRON UNTUK INISIALISASI DATATABLES (Diperbarui) ---
        async function initializeDataTable() {
            const loadingMessage = document.getElementById('loading-message');
            const tableBody = document.getElementById('reportTableBody');

            // 0. Ambil data dari API
            const reportData = await fetchDataFromAPI();

            loadingMessage.classList.remove('hidden');

            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            if (reportData.length === 0) {
                // Tampilkan pesan "Tidak ada data" jika array kosong (baik dari API yang kosong atau karena error)
                tableBody.innerHTML = `
                    <tr class="bg-white">
                        <td colspan="10" class="px-6 py-4 text-center font-medium text-gray-700">Tidak ada data laporan yang tersedia.</td>
                    </tr>
                `;
                loadingMessage.classList.add('hidden');
                return;
            }

            // 1. Buat array Promise untuk menjalankan semua panggilan API (Nominatim) secara paralel
            const dataPromises = reportData.map(async (report, index) => {
                // PANGGIL FUNGSI ASINKRON NOMINATIM
                // Pastikan objek laporan memiliki properti latitude dan longitude.
                const kabupaten = await getKabupatenFromCoords(report.latitude, report.longitude);

                const fileCount = report.files ? report.files.length : 0;
                const fileColumnContent = fileCount > 0 ?
                    `<button onclick='openModal(${JSON.stringify(report.files)})' class="flex items-center justify-center mx-auto px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-semibold rounded-full hover:bg-indigo-100 transition duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13.5" /></svg>
                        ${fileCount} Lampiran
                    </button>` :
                    '<span class="text-gray-400 block text-center">- Tidak Ada -</span>';

                let flagColor = '';
                if (report.flag === 'NON COMPLY') {
                    flagColor = 'bg-red-100 text-red-800';
                } else if (report.flag === 'COMPLY') {
                    flagColor = 'bg-green-100 text-green-800';
                } else {
                    flagColor = 'bg-blue-100 text-blue-800';
                }

                const flagHtml = `<span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium ${flagColor}">
                    ${report.flag.charAt(0).toUpperCase() + report.flag.slice(1)}
                </span>`;

                return [
                    index + 1,
                    report.operator,
                    `<span data-order="${report.harga}">${formatter.format(report.harga)}</span>`,
                    report.kuota_gb,
                    report.masa_aktif_hari,
                    report.ppgb,
                    flagHtml,
                    kabupaten, // DATA LOKASI ASINKRON
                    report.user_email || '-',
                    fileColumnContent
                ];
            });

            // 2. Tunggu hingga semua panggilan API selesai
            const dataForDatatables = await Promise.all(dataPromises);

            // 3. Sembunyikan pesan loading
            loadingMessage.classList.add('hidden');

            // 4. Inisialisasi DataTables
            $('#reportTable').DataTable({
                data: dataForDatatables,
                scrollX: true,

                rowCallback: function(row, data, index) {
                    $(row).addClass('data-row border-b border-gray-100');
                    $(row).removeClass('odd even dt-row');

                    if (index % 2 === 0) {
                        $(row).addClass('data-row-even');
                    } else {
                        $(row).addClass('data-row-odd');
                    }

                    // Menyesuaikan gaya kolom
                    $('td:eq(0)', row).addClass('px-6 py-4 font-bold text-gray-900');
                    $('td:eq(1)', row).addClass('px-6 py-4 font-medium text-gray-800');
                    $('td:eq(2)', row).addClass('px-6 py-4 text-right font-semibold text-green-600');
                    $('td:eq(3), td:eq(4), td:eq(5)', row).addClass('px-6 py-4 text-center');
                    $('td:eq(6), td:eq(9)', row).addClass('px-6 py-4 text-center');
                    $('td:eq(7)', row).addClass(
                        'px-6 py-4 font-medium text-indigo-700'); // WARNA BIRU UNTUK LOKASI
                    $('td:eq(8)', row).addClass('px-6 py-4');
                },

                initComplete: function() {
                    const dtContainer = $('#reportTable').closest('.dt-container');
                    dtContainer.removeClass('dark');
                },

                // Konfigurasi bahasa ke Bahasa Indonesia
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.0.8/i18n/id.json',
                },
                columnDefs: [{
                        targets: 6,
                        orderable: false
                    },
                    {
                        targets: 9,
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        }

        // Mulai inisialisasi DataTables setelah DOM siap
        $(document).ready(() => {
            initializeDataTable();
        });
    </script>
</body>

</html>
