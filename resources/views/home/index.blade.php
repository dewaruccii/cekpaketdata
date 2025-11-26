<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Paket Internet</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Menggunakan font Inter untuk tampilan yang bersih */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fb;
        }

        /* Custom styling untuk animasi loading */
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #10b981;
            /* Warna hijau Tailwind untuk simulasi 'Save' */
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981',
                        /* Hijau untuk aksi "Simpan" */
                        secondary: '#059669',
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg bg-white shadow-xl rounded-2xl p-6 md:p-8 border border-gray-100">
        <!-- Header -->
        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Input Data Paket Baru</h1>
        <p class="text-gray-500 mb-6">Masukkan detail paket data internet yang ingin Anda simpan dan cek kepatuhan
            harganya.</p>

        <!-- Form Input Area -->
        <div class="space-y-4">
            <!-- Pilihan Operator -->
            <div>
                <label for="operator" class="block text-sm font-medium text-gray-700 mb-1">Pilih Operator</label>
                <select id="operator"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                    <option value="" disabled selected>-- Pilih Operator Seluler --</option>
                    <option value="Telkomsel">Telkomsel</option>
                    <option value="Indosat Ooredoo">IOH</option>
                    <option value="XL Axiata">XL Smart</option>
                </select>
            </div>

            <!-- Nama Paket -->
            {{-- <div>
                <label for="packageName" class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
                <input type="text" id="packageName" placeholder="Contoh: Kuota Harian 1GB"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
            </div> --}}

            <!-- Input Harga -->
            <div>
                <label for="hargaInput" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input type="text" id="hargaInput" placeholder="Contoh: 50000"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
            </div>

            <!-- Input Kuota -->
            <div>
                <label for="kuotaInput" class="block text-sm font-medium text-gray-700 mb-1">Kuota (Harus mengandung
                    angka GB)</label>
                <input type="text" id="kuotaInput" placeholder="Contoh: 15GB All Network"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
            </div>

            <!-- Input Masa Aktif -->
            <div>
                <label for="masaAktifInput" class="block text-sm font-medium text-gray-700 mb-1">Masa Aktif (Cukup di
                    tulis angka saja)</label>
                <input type="text" id="masaAktifInput" placeholder="Contoh: 30 Hari"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
            </div>

            <!-- Tombol Simpan --><button onclick="submitPackage()" id="checkButton"
                class="w-full bg-primary text-white p-3 rounded-lg font-semibold hover:bg-secondary transition duration-300 ease-in-out shadow-md shadow-primary/40 flex items-center justify-center disabled:opacity-50"
                disabled>
                <span id="buttonText">Simpan & Hitung Kepatuhan</span>
                <div id="loader" class="loader ml-2 hidden"></div>
            </button>
        </div>

        <!-- Area Hasil Konfirmasi -->
        <div id="results" class="mt-8">
            <!-- Konfirmasi hasil akan ditampilkan di sini -->
        </div>

        <!-- Alert/Error Message (for custom messages, replacing alert()) -->
        <div id="alertBox" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
            <div
                class="bg-white p-6 rounded-xl shadow-2xl max-w-sm w-full transform transition-all scale-100 opacity-100">
                <h3 id="alertTitle" class="text-xl font-bold text-red-600 mb-3">Error</h3>
                <p id="alertMessage" class="text-gray-600 mb-4"></p>
                <button onclick="closeAlert()"
                    class="w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        // Deklarasi elemen input
        const operatorSelect = document.getElementById('operator');
        const packageNameInput = document.getElementById('packageName');
        const hargaInput = document.getElementById('hargaInput');
        const kuotaInput = document.getElementById('kuotaInput');
        const masaAktifInput = document.getElementById('masaAktifInput');

        const checkButton = document.getElementById('checkButton');
        const resultsDiv = document.getElementById('results');
        const loader = document.getElementById('loader');
        const buttonText = document.getElementById('buttonText');
        const alertBox = document.getElementById('alertBox');
        const alertTitle = document.getElementById('alertTitle');
        const alertMessage = document.getElementById('alertMessage');

        // Data PPGB Minimum berdasarkan Harga Bulanan (dari snippet CSV)
        // Rentang Harga (dalam Rupiah, Monthly Price Normalized)
        // <32000: PPGB Min 4.0
        // 32000 - 34000: PPGB Min 4.0
        // 35000 - 39000: PPGB Min 3.5
        // 40000 - 49000: PPGB Min 3.0
        // 50000 - 59000: PPGB Min 2.5
        // 60000 - 69000: PPGB Min 2.25
        // 70000 - 79000: PPGB Min 2.0
        // >80000: PPGB Min 2.0
        const MIN_PPGB_THRESHOLDS = [{
                maxPrice: 31000,
                minPPGB: 4
            }, // Price <= 32k
            {
                maxPrice: 34000,
                minPPGB: 4
            }, // 32k - 34k
            {
                maxPrice: 39000,
                minPPGB: 3.5
            }, // 35k - 39k
            {
                maxPrice: 49000,
                minPPGB: 3
            }, // 40k - 49k
            {
                maxPrice: 59000,
                minPPGB: 2.5
            }, // 50k - 59k
            {
                maxPrice: 69000,
                minPPGB: 2.25
            }, // 60k - 69k
            {
                maxPrice: 79000,
                minPPGB: 2
            }, // 70k - 79k
            {
                maxPrice: 89000,
                minPPGB: 2
            }, // 70k - 79k
            {
                maxPrice: 99000,
                minPPGB: 1.8
            }, // 70k - 79k
            {
                maxPrice: 109000,
                minPPGB: 1.5
            }, // 70k - 79k
            {
                maxPrice: 119000,
                minPPGB: 1.5
            }, // 70k - 79k
            {
                maxPrice: 149000,
                minPPGB: 1.5
            }, // 70k - 79k
            {
                maxPrice: 200000,
                minPPGB: 1.0
            }, // 70k - 79k
            {
                maxPrice: Infinity,
                minPPGB: 0.56
            } // 80k+
        ];

        // --- Utility Functions ---

        function showAlert(title, message, isError = true) {
            alertTitle.textContent = title;
            alertMessage.textContent = message;
            alertTitle.className = `text-xl font-bold ${isError ? 'text-red-600' : 'text-primary'} mb-3`;

            const closeButton = alertBox.querySelector('button');
            closeButton.className =
                `w-full text-white p-2 rounded-lg transition ${isError ? 'bg-red-500 hover:bg-red-600' : 'bg-primary hover:bg-secondary'}`;

            alertBox.classList.remove('hidden');
            alertBox.classList.add('flex');
        }

        function closeAlert() {
            alertBox.classList.add('hidden');
            alertBox.classList.remove('flex');
        }

        // Memastikan input adalah string sebelum memanggil .replace()
        function cleanRupiahFormat(value) {
            if (value === null || value === undefined) {
                value = '';
            }
            // Konversi ke string dijamin terjadi di sini
            return String(value).replace(/[^,\d]/g, '').replace(/,/g, '');
        }

        function formatRupiah(amount) {
            // Memastikan amount adalah string sebelum diproses
            if (amount === null || amount === undefined) {
                amount = '';
            }

            let number_string = cleanRupiahFormat(amount).toString();
            if (!number_string) return ''; // Tambahkan cek untuk string kosong setelah dibersihkan

            let sisa = number_string.length % 3;
            let rupiah = number_string.substr(0, sisa);
            let ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return 'Rp ' + rupiah;
        }

        // Fungsi untuk mengekstrak angka dari input Kuota (GB)
        function extractNumericGB(value) {
            const match = String(value).match(/(\d+(\.\d+)?)/); // Cari angka (termasuk desimal)
            return match ? parseFloat(match[1]) : NaN;
        }

        // Fungsi untuk mengekstrak angka dari input Masa Aktif (Hari)
        function extractNumericDays(value) {
            const valueStr = String(value); // Konversi ke string untuk keamanan
            const daysMatch = valueStr.match(/(\d+)\s*(hari|day|days)/i);
            if (daysMatch) return parseInt(daysMatch[1]);

            const monthMatch = valueStr.match(/(\d+)\s*(bulan|month|months)/i);
            if (monthMatch) return parseInt(monthMatch[1]) * 30; // Asumsi 1 bulan = 30 hari

            const simpleNumberMatch = valueStr.match(/^\s*(\d+)\s*$/); // Angka saja
            if (simpleNumberMatch) return parseInt(simpleNumberMatch[1]); // Anggap sebagai hari jika angka tunggal

            return NaN;
        }

        // --- Calculation Logic ---

        /**
         * Mencari Minimum PPGB berdasarkan Harga Bulanan.
         * @param {number} monthlyPrice Harga Bulanan yang sudah dinormalisasi (numeric).
         * @returns {number} Nilai PPGB Minimum.
         */
        function getMinPPGB(monthlyPrice) {
            // Kita harus mengalikan 1000 karena threshold di CSV adalah dalam satuan ribuan (e.g., 3.5 = 3500)
            const priceInK = monthlyPrice / 1000;

            for (const threshold of MIN_PPGB_THRESHOLDS) {
                // Pengecekan dilakukan berdasarkan harga bulanan yang dinormalisasi (dalam Rupiah)
                if (monthlyPrice <= threshold.maxPrice) {
                    return threshold.minPPGB;
                }
            }
            // Default jika harga sangat tinggi (di atas 79k)
            return 2;
        }

        /**
         * Melakukan semua perhitungan dan pengecekan kepatuhan.
         */
        function calculateCompliance(price, days, gb) {
            let monthlyPrice = 0;
            let ppgb = 0;
            let minPPGB = 0;
            let flag = "ERROR";

            if (days > 0 && gb > 0) {
                // 1. Hitung Harga Bulanan (Monthly Price)
                // Rumus: Harga Asli * (30 / Masa Aktif Hari)
                monthlyPrice = price * (30 / days);

                // 2. Hitung PPGB (Price Per Gigabyte) - dalam Ribuan Rupiah
                // Rumus: (Harga Bulanan / Kuota GB) / 1000
                ppgb = (monthlyPrice / gb) / 1000;

                // 3. Ambil Minimum PPGB dari tabel threshold
                minPPGB = getMinPPGB(monthlyPrice);

                // 4. Cek Kepatuhan
                // PPGB Hitung harus LEBIH KECIL atau SAMA DENGAN PPGB Minimum
                flag = (ppgb >= minPPGB) ? "COMPLY" : "NON COMPLY";
                // console.log(ppgb, minPPGB,, 'tes out');

            } else {
                flag = "INVALID INPUT";
                // Jika input tidak valid, kita masih bisa mencari minimum PPGB berdasarkan harga aslinya (walau Monthly Price tidak terhitung)
                minPPGB = getMinPPGB(price);
            }

            return {
                monthlyPrice: monthlyPrice,
                ppgb: ppgb,
                minPPGB: minPPGB,
                flag: flag
            };
        }


        // --- Event Handlers & Validation ---

        function validateInput() {
            const operator = operatorSelect.value;
            // const packageName = packageNameInput.value.trim();
            const hargaNumeric = cleanRupiahFormat(hargaInput.value).trim();
            const kuotaGB = extractNumericGB(kuotaInput.value);
            const masaAktifDays = extractNumericDays(masaAktifInput.value);

            const isPriceValid = hargaNumeric && !isNaN(parseInt(hargaNumeric));
            const isKuotaValid = !isNaN(kuotaGB) && kuotaGB > 0;
            const isDaysValid = !isNaN(masaAktifDays) && masaAktifDays > 0;

            if (operator && isPriceValid && isKuotaValid && isDaysValid) {
                console.log('false');

                checkButton.disabled = false;
            } else {
                checkButton.disabled = true;
                console.log('true');

            }
        }

        // Event listeners untuk format Rupiah
        hargaInput.addEventListener('input', function(e) {
            this.value = formatRupiah(this.value);
            validateInput();
        });

        hargaInput.addEventListener('blur', function(e) {
            if (this.value) {
                this.value = formatRupiah(cleanRupiahFormat(this.value));
            }
            validateInput();
        });

        // Event listeners untuk validasi umum
        operatorSelect.addEventListener('change', validateInput);
        // packageNameInput.addEventListener('input', validateInput);
        kuotaInput.addEventListener('input', validateInput);
        masaAktifInput.addEventListener('input', validateInput);


        /**
         * Fungsi utama untuk mensimulasikan proses simpan data dan perhitungan.
         */
        function submitPackage() {
            const price = parseInt(cleanRupiahFormat(hargaInput.value).trim());
            const gb = extractNumericGB(kuotaInput.value);
            const days = extractNumericDays(masaAktifInput.value);

            // Validasi akhir
            if (isNaN(price) || isNaN(gb) || isNaN(days) || price <= 0 || gb <= 0 || days <= 0) {
                showAlert("Validasi Gagal",
                    "Pastikan Harga, Kuota (GB), dan Masa Aktif (Hari) diisi dengan angka yang valid dan lebih dari nol."
                );
                return;
            }

            // Lakukan Perhitungan
            const calculation = calculateCompliance(price, days, gb);

            // Tampilkan loading state
            checkButton.disabled = true;
            buttonText.textContent = 'Menghitung...';
            loader.classList.remove('hidden');
            resultsDiv.innerHTML = '';

            // Simulasikan proses simpan/API dengan delay 1.5 detik
            setTimeout(() => {
                try {
                    const packageData = {
                        operator: operatorSelect.value,
                        // name: packageNameInput.value.trim(),
                        harga: formatRupiah(price),
                        kuota: kuotaInput.value.trim(),
                        masa_aktif: masaAktifInput.value.trim(),
                    };

                    renderConfirmation(packageData, calculation);

                } catch (error) {
                    console.error("Error during package submission simulation:", error);
                    showAlert("Kesalahan Sistem", "Terjadi kesalahan saat memproses perhitungan. Coba lagi.");
                } finally {
                    // Sembunyikan loading state
                    checkButton.disabled = false;
                    buttonText.textContent = 'Simpan & Hitung Kepatuhan';
                    loader.classList.add('hidden');
                    validateInput();
                }

            }, 1500); // 1.5 detik delay simulasi
        }

        /**
         * Menampilkan konfirmasi data dan hasil perhitungan.
         * @param {Object} pkg Data paket yang disubmit.
         * @param {Object} calc Hasil perhitungan compliance.
         */
        function renderConfirmation(pkg, calc) {
            const isComply = calc.flag === "COMPLY";
            const flagColor = isComply ? 'bg-primary text-white' : 'bg-red-500 text-white';
            const flagText = isComply ? 'COMPLY (PATUH)' : 'NON COMPLY (TIDAK PATUH)';
            const flagIcon = isComply ? '✅' : '❌';

            resultsDiv.innerHTML = `
                <div class="${isComply ? 'bg-primary/10 border-primary text-green-900' : 'bg-red-100 border-red-500 text-red-900'} border-l-4 p-4 mb-6 rounded-lg">
                    <p class="font-bold">✨ Perhitungan Selesai!</p>
                    <p class="text-sm">Data paket Anda telah dihitung dan dicek kepatuhannya (Simulasi Hasil).</p>
                </div>
                <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-md">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">${pkg.name} (${pkg.operator})</h3>

                    <!-- Basic Data -->
                    <div class="text-sm text-gray-600 space-y-2 pb-4 border-b">
                        <p class="flex justify-between items-center"><span class="font-medium text-gray-700">Harga Asli:</span> <span class="text-right font-semibold text-gray-800">${pkg.harga}</span></p>
                        <p class="flex justify-between items-center"><span class="font-medium text-gray-700">Kuota Input:</span> <span class="text-right">${pkg.kuota}</span></p>
                        <p class="flex justify-between items-center"><span class="font-medium text-gray-700">Masa Aktif Input:</span> <span class="text-right">${pkg.masa_aktif}</span></p>
                    </div>

                    <!-- Calculation Results -->
                    <h4 class="text-lg font-bold text-gray-700 mt-4 mb-2">Hasil Analisis Harga:</h4>
                    <div class="text-sm text-gray-600 space-y-2">
                        <p class="flex justify-between items-center"><span class="font-medium text-gray-700">Harga Bulanan</span> <span class="text-right font-semibold">${formatRupiah(calc.monthlyPrice)}</span></p>
                        <p class="flex justify-between items-center"><span class="font-medium text-gray-700">PPGB:</span> <span class="text-right font-semibold text-blue-600">${calc.ppgb.toFixed(2)}</span></p>
                        <p class="flex justify-between items-center"><span class="font-medium text-gray-700">PPGB Minimum:</span> <span class="text-right font-semibold text-gray-800">${calc.minPPGB.toFixed(2)}</span></p>
                    </div>

                    <!-- Compliance Flag -->
                    <div class="mt-4 p-3 text-center rounded-lg font-bold text-lg ${flagColor}">
                        ${flagIcon} STATUS KEPATUHAN: ${flagText}
                    </div>
                </div>
            `;
        }

        // Inisialisasi: memanggil validasi saat halaman dimuat
        window.onload = validateInput;
    </script>
</body>

</html>
