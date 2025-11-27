<!DOCTYPE html>

<html lang="id">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cek Kepatuhan Harga Paket Data</title>

    <!-- Load Tailwind CSS -->

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Load Lucide Icons untuk ikon yang modern -->

    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}" />

    <link rel="apple-touch-icon" type="image/png" sizes="180x180" href="{{ asset('assets/img/logo.png') }}" />

    <style>
        /* Menggunakan font Inter untuk tampilan yang bersih */

        body {

            font-family: 'Inter', sans-serif;

            background-color: #f0f4f8;

            /* Background lebih soft */

        }



        /* Custom styling untuk animasi loading */

        .loader {

            border: 4px solid #f3f3f3;

            border-top: 4px solid #10b981;

            /* Warna hijau primary */

            border-radius: 50%;

            width: 20px;

            height: 20px;

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



        /* Style untuk input saat fokus */

        .input-focus-style:focus {

            --tw-ring-color: #10b981;

            border-color: #10b981;

            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);

            /* Ring shadow kustom */

        }
    </style>

    <script>
        // Konfigurasi Tailwind untuk warna kustom

        tailwind.config = {

            theme: {

                extend: {

                    colors: {

                        primary: '#10b981',

                        /* Hijau Solid */

                        secondary: '#059669',

                        info: '#3b82f6',

                        /* Biru untuk informasi */

                        success: '#10b981',

                        danger: '#ef4444',

                    }

                }

            }

        }
    </script>

</head>



<body class="min-h-screen flex items-start justify-center p-4 md:p-8">



    <div class="w-full max-w-xl bg-white shadow-2xl rounded-3xl p-6 md:p-10 transform transition-all duration-300">

        <!-- Header Aplikasi -->

        <div class="flex items-center space-x-3 mb-6">

            <img src="{{ asset('assets/img/telkomsel-seeklogo.png') }}" width="50" alt="">

            <h1 class="text-3xl font-extrabold text-gray-800">Cek Kepatuhan Harga</h1>

            <img src="{{ asset('assets/img/logo.png') }}" class="absolute top-2 right-3" width="50" alt="">

        </div>

        <p class="text-gray-500 mb-8 border-b pb-4">Masukkan detail paket data internet Anda untuk menghitung dan

            memeriksa Price Per Gigabyte (PPGB) terhadap ambang batas kepatuhan.</p>



        <!-- Form Input Area -->

        <div class="space-y-6">



            <!-- Pilihan Operator -->

            <div>

                <label for="operator" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">

                    <i data-lucide="phone" class="w-4 h-4 mr-2 text-info"></i> Operator

                </label>

                <select id="operator"
                    class="w-full p-3.5 border border-gray-300 rounded-xl shadow-inner bg-gray-50 text-gray-700 input-focus-style transition duration-150 ease-in-out">

                    <option value="" disabled selected>-- Pilih Operator Seluler --</option>

                    <option value="Telkomsel">Telkomsel</option>
                    <option value="Indosat">Indosat</option>
                    <option value="XL">XL</option>
                    <option value="Axis">Axis</option>
                    <option value="Smart">Smart</option>
                    <option value="Three">Three</option>

                </select>

            </div>



            <!-- Input Harga -->

            <div>

                <label for="hargaInput" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">

                    <i data-lucide="wallet" class="w-4 h-4 mr-2 text-info"></i> Harga Paket (Rp)

                </label>

                <div class="relative">

                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-bold">Rp</span>

                    <input type="text" id="hargaInput" placeholder="Contoh: 50.000"
                        class="w-full pl-10 pr-3 p-3.5 border border-gray-300 rounded-xl shadow-inner bg-gray-50 text-gray-700 input-focus-style transition duration-150 ease-in-out">

                </div>

            </div>



            <!-- Input Kuota -->

            <div>

                <label for="kuotaInput" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">

                    <i data-lucide="hard-drive" class="w-4 h-4 mr-2 text-info"></i> Kuota (GB)

                </label>

                <div class="relative">

                    <input type="text" id="kuotaInput" placeholder="Contoh: 15 (cukup angka saja)"
                        class="w-full pr-12 p-3.5 border border-gray-300 rounded-xl shadow-inner bg-gray-50 text-gray-700 input-focus-style transition duration-150 ease-in-out">

                    <span
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-primary font-bold text-sm">GB</span>

                </div>

            </div>



            <!-- Input Masa Aktif -->

            <div>

                <label for="masaAktifInput" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">

                    <i data-lucide="calendar" class="w-4 h-4 mr-2 text-info"></i> Masa Aktif (Hari)

                </label>

                <div class="relative">

                    <input type="text" id="masaAktifInput" placeholder="Contoh: 30 (cukup angka saja)"
                        class="w-full pr-14 p-3.5 border border-gray-300 rounded-xl shadow-inner bg-gray-50 text-gray-700 input-focus-style transition duration-150 ease-in-out">

                    <span
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-primary font-bold text-sm">Hari</span>

                </div>

            </div>



            <!-- Tombol Simpan -->

            <button onclick="submitPackage()" id="checkButton"
                class="w-full bg-primary text-white p-4 rounded-xl font-bold text-lg hover:bg-secondary transition duration-300 ease-in-out shadow-lg shadow-primary/30 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                disabled>

                <span id="buttonText">Simpan & Hitung Kepatuhan</span>

                <div id="loader" class="loader ml-3 hidden"></div>

            </button>

            <div class="text-center mt-4 text-gray-400 text-sm">

                <span>2025 © CPM A2</span>

            </div>



        </div>



        <!-- Area Hasil Konfirmasi -->

        <div id="results" class="mt-8">

            <!-- Konfirmasi hasil akan ditampilkan di sini -->

        </div>



        <!-- Alert/Error Message (for custom messages, replacing alert()) -->

        <div id="alertBox" class="fixed inset-0 bg-gray-900 bg-opacity-70 hidden items-center justify-center z-50 p-4"
            onclick="closeAlert()">

            <div class="bg-white p-6 rounded-2xl shadow-2xl max-w-sm w-full transform transition-all duration-300 scale-100 opacity-100"
                onclick="event.stopPropagation()">

                <div class="flex justify-between items-center mb-3">

                    <h3 id="alertTitle" class="text-xl font-bold text-red-600">Error</h3>

                    <button onclick="closeAlert()" class="text-gray-400 hover:text-gray-600">

                        <i data-lucide="x" class="w-6 h-6"></i>

                    </button>

                </div>

                <p id="alertMessage" class="text-gray-600 mb-6"></p>

                <button onclick="closeAlert()"
                    class="w-full bg-red-500 text-white p-3 rounded-xl font-semibold hover:bg-red-600 transition shadow-md shadow-red-500/30">Tutup</button>

            </div>

        </div>



        <!-- Footer for Icon rendering -->

        <script>
            // Render Lucide icons

            lucide.createIcons();
        </script>

    </div>



    <script>
        // Deklarasi elemen input

        const operatorSelect = document.getElementById('operator');

        // const packageNameInput = document.getElementById('packageName'); // Dihapus dari HTML baru

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



        // Data PPGB Minimum berdasarkan Harga Bulanan (dari snippet CSV) - LOGIC TIDAK DIUBAH

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

                `w-full p-3 rounded-xl font-semibold transition shadow-md ${isError ? 'bg-red-500 hover:bg-red-600 text-white shadow-red-500/30' : 'bg-primary hover:bg-secondary text-white shadow-primary/30'}`;



            alertBox.classList.remove('hidden');

            alertBox.classList.add('flex');

            lucide.createIcons(); // Render ikon dalam modal

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

            return rupiah; // Mengembalikan angka tanpa 'Rp ' karena sudah ada di input field

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

                // monthlyPrice = price * (30 / days);
                if (days < 28) {
                    monthlyPrice = (price / days) * 28;
                } else {
                    monthlyPrice = price;
                }



                // console.log(monthlyPrice, price, '636');



                // 2. Hitung PPGB (Price Per Gigabyte) - dalam Ribuan Rupiah

                // Rumus: (Harga Bulanan / Kuota GB) / 1000

                ppgb = (monthlyPrice / gb) / 1000;



                // 3. Ambil Minimum PPGB dari tabel threshold

                minPPGB = getMinPPGB(monthlyPrice);



                // 4. Cek Kepatuhan - LOGIC INI TIDAK DIUBAH SAMA SEKALI

                // PPGB Hitung harus LEBIH KECIL atau SAMA DENGAN PPGB Minimum

                if (price < 6000) {

                    flag = "NON COMPLY";

                    ppgb = (price / gb) / 1000;

                    console.log('dsjs');





                } else if (price < 32000) {



                    ppgb = (price / gb) / 1000;



                    if (monthlyPrice < 32000) {

                        flag = "NON COMPLY";



                    } else {



                        flag = (ppgb >= minPPGB) ? "COMPLY" : "NON COMPLY";

                    }





                } else {



                    flag = (ppgb >= minPPGB) ? "COMPLY" : "NON COMPLY";

                }

                console.log(ppgb, minPPGB, flag, price, monthlyPrice, days, gb, 'tes out');



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

                // console.log('false');



                checkButton.disabled = false;

            } else {

                checkButton.disabled = true;

                // console.log('true');



            }

        }



        // Event listeners untuk format Rupiah

        hargaInput.addEventListener('input', function(e) {

            this.value = formatRupiah(this.value);

            validateInput();

        });



        hargaInput.addEventListener('blur', function(e) {

            if (this.value) {

                // Saat blur, pastikan formatnya benar

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

                        harga: price, // Simpan harga numerik untuk diproses di renderConfirmation

                        kuota_raw: kuotaInput.value.trim(),

                        masa_aktif_raw: masaAktifInput.value.trim(),

                        kuota_gb: gb,

                        masa_aktif_hari: days

                    };



                    renderConfirmation(packageData, calculation);



                } catch (error) {

                    console.error("Error during package submission simulation:", error);

                    showAlert("Kesalahan Sistem", "Terjadi kesalahan saat memproses perhitungan. Coba lagi.");

                } finally {

                    // Sembunyikan loading state

                    // Perlu cek ulang validasi karena input mungkin sudah diubah saat loading

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

            const flagBg = isComply ? 'bg-success/90' : 'bg-danger/90';

            const flagRing = isComply ? 'ring-success/50' : 'ring-danger/50';

            const flagText = isComply ? 'COMPLY (PATUH)' : 'NON COMPLY (TIDAK PATUH)';

            const flagIcon = isComply ? 'check-circle' : 'x-circle';

            const flagEmoji = isComply ? '🎉' : '⚠️';



            const hargaFormatted = new Intl.NumberFormat('id-ID', {

                style: 'currency',

                currency: 'IDR',

                minimumFractionDigits: 0,

                maximumFractionDigits: 0

            }).format(pkg.harga);



            const monthlyPriceFormatted = new Intl.NumberFormat('id-ID', {

                style: 'currency',

                currency: 'IDR',

                minimumFractionDigits: 0,

                maximumFractionDigits: 0

            }).format(calc.monthlyPrice);



            resultsDiv.innerHTML = `

                <div class="p-5 rounded-2xl shadow-xl border ${isComply ? 'border-success bg-success/5' : 'border-danger bg-danger/5'}">

                    <div class="flex items-center space-x-3 mb-4">

                        <i data-lucide="${flagIcon}" class="w-7 h-7 ${isComply ? 'text-success' : 'text-danger'}"></i>

                        <h3 class="text-xl font-bold ${isComply ? 'text-success-900' : 'text-danger-900'}">${flagEmoji} Hasil Perhitungan</h3>

                    </div>



                    <div class="bg-white p-4 rounded-xl shadow-sm mb-4 space-y-3">

                        <p class="flex justify-between items-center text-sm">

                            <span class="font-medium text-gray-600">Operator:</span>

                            <span class="font-bold text-gray-800">${pkg.operator}</span>

                        </p>

                        <p class="flex justify-between items-center text-sm">

                            <span class="font-medium text-gray-600">Harga (Asli):</span>

                            <span class="font-bold text-primary">${hargaFormatted}</span>

                        </p>

                        <p class="flex justify-between items-center text-sm">

                            <span class="font-medium text-gray-600">Kuota:</span>

                            <span class="font-bold text-gray-800">${pkg.kuota_gb} GB (${pkg.kuota_raw})</span>

                        </p>

                        <p class="flex justify-between items-center text-sm">

                            <span class="font-medium text-gray-600">Masa Aktif:</span>

                            <span class="font-bold text-gray-800">${pkg.masa_aktif_hari} Hari (${pkg.masa_aktif_raw})</span>

                        </p>

                    </div>



                    <h4 class="text-md font-bold text-gray-700 mt-5 mb-3 border-t pt-4">Detail Kepatuhan:</h4>

                    <div class="space-y-3">

                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">

                            <span class="font-medium text-gray-600">Harga Bulanan Normalisasi:</span>

                            <span class="font-extrabold text-lg text-info">${monthlyPriceFormatted}</span>

                        </div>

                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">

                            <span class="font-medium text-gray-600">PPGB (Hitung):</span>

                            <span class="font-bold text-blue-600">${calc.ppgb.toFixed(2)}</span>

                        </div>

                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">

                            <span class="font-medium text-gray-600">PPGB Minimum (Ambang Batas):</span>

                            <span class="font-bold text-gray-800">${calc.minPPGB.toFixed(2)}</span>

                        </div>

                    </div>



                    <!-- Compliance Flag -->

                    <div class="mt-6 p-4 text-center rounded-xl font-extrabold text-white text-xl shadow-lg ring-4 ${flagBg} ${flagRing}">

                        <span class="uppercase">${flagText}</span>

                    </div>

                </div>

            `;

            // Re-render Lucide icons for the new result block

            lucide.createIcons();

        }



        // Inisialisasi: memanggil validasi saat halaman dimuat

        window.onload = () => {

            validateInput();

            // Inisialisasi format Rupiah jika ada nilai default

            if (hargaInput.value) {

                hargaInput.value = formatRupiah(hargaInput.value);

            }

        };
    </script>

</body>



</html>
