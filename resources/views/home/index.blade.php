<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Harga Paket</title>
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
        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Cek Harga Paket</h1>
        <p class="text-gray-500 mb-6">Masukkan detail paket data internet yang ingin Anda cek.</p>

        <!-- Form Input Area -->
        <div class="space-y-4">
            <!-- Pilihan Operator -->
            <div>
                <label for="operator" class="block text-sm font-medium text-gray-700 mb-1">Pilih Operator</label>
                <select id="operator"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
                    <option value="" disabled selected>-- Pilih Operator Seluler --</option>
                    <option value="Telkomsel">Telkomsel</option>
                    <option value="Indosat Ooredoo">Indosat Ooredoo</option>
                    <option value="XL Axiata">XL Axiata</option>
                    <option value="Tri (3)">Tri (3)</option>
                    <option value="Smartfren">Smartfren</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <!-- Nama Paket -->
            <!--<div>-->
            <!--    <label for="packageName" class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>-->
            <!--    <input type="text" id="packageName" placeholder="Contoh: Kuota Harian 1GB" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">-->
            <!--</div>-->

            <!-- Input Harga -->
            <div>
                <label for="hargaInput" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input type="text" id="hargaInput" placeholder="Contoh: 50000"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
            </div>

            <!-- Input Kuota -->
            <div>
                <label for="kuotaInput" class="block text-sm font-medium text-gray-700 mb-1">Kuota (Contoh: 15) Note:
                    untuk kuota dalam hitungan GB</label>
                <input type="text" id="kuotaInput" placeholder="Masukkan detail kuota"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
            </div>

            <!-- Input Masa Aktif -->
            <div>
                <label for="masaAktifInput" class="block text-sm font-medium text-gray-700 mb-1">Masa Aktif (Contoh: 30
                    Hari)</label>
                <input type="text" id="masaAktifInput" placeholder="Masukkan masa aktif"
                    class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary transition duration-150 ease-in-out">
            </div>

            <!-- Tombol Simpan --><button onclick="submitPackage()" id="checkButton"
                class="w-full bg-primary text-white p-3 rounded-lg font-semibold hover:bg-secondary transition duration-300 ease-in-out shadow-md shadow-primary/40 flex items-center justify-center disabled:opacity-50"
                disabled>
                <span id="buttonText">Cek Harga Paket</span>
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
        // Deklarasi elemen input baru
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


        // Fungsi untuk menampilkan pesan kustom
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

        // Fungsi untuk memvalidasi semua input dan mengaktifkan tombol
        function validateInput() {
            const operator = operatorSelect.value;
            const packageName = packageNameInput.value.trim();
            // Untuk harga, kita akan membersihkan dulu dari format rupiah sebelum validasi
            const hargaNumeric = cleanRupiahFormat(hargaInput.value).trim();
            const kuota = kuotaInput.value.trim();
            const masaAktif = masaAktifInput.value.trim();

            // Tombol aktif jika semua field terisi dan harga adalah angka valid (setelah dibersihkan)
            if (operator && packageName && hargaNumeric && !isNaN(parseInt(hargaNumeric)) && kuota && masaAktif) {
                checkButton.disabled = false;
            } else {
                checkButton.disabled = true;
            }
        }

        // Event listeners untuk validasi
        operatorSelect.addEventListener('change', validateInput);
        packageNameInput.addEventListener('input', validateInput);
        // hargaInput.addEventListener('input', validateInput); // Diganti dengan event handler formatRupiah
        kuotaInput.addEventListener('input', validateInput);
        masaAktifInput.addEventListener('input', validateInput);


        // --- Fungsi Format Rupiah Otomatis ---

        // Fungsi untuk membersihkan string dari format Rupiah dan mengembalikan hanya angka
        function cleanRupiahFormat(value) {
            return value.replace(/[^,\d]/g, '').replace(/,/g, '');
        }

        // Fungsi untuk memformat angka menjadi Rupiah
        function formatRupiah(amount) {
            if (!amount) return '';
            let number_string = cleanRupiahFormat(amount).toString();
            let sisa = number_string.length % 3;
            let rupiah = number_string.substr(0, sisa);
            let ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return 'Rp ' + rupiah;
        }

        // Event listener untuk input harga
        hargaInput.addEventListener('input', function(e) {
            this.value = formatRupiah(this.value);
            validateInput(); // Panggil validasi setelah format
        });

        // Event listener untuk harga saat kehilangan fokus (blur) - opsional, tapi bagus untuk memastikan format akhir
        hargaInput.addEventListener('blur', function(e) {
            // Jika ada nilai, pastikan terformat dengan benar
            if (this.value) {
                this.value = formatRupiah(cleanRupiahFormat(this.value));
            }
            validateInput();
        });

        // --- Akhir Fungsi Format Rupiah Otomatis ---


        /**
         * Fungsi utama untuk mensimulasikan proses simpan data.
         */
        function submitPackage() {
            const packageData = {
                operator: operatorSelect.value,
                name: packageNameInput.value.trim(),
                // Ambil nilai harga yang sudah bersih dari format rupiah untuk disimpan
                harga: cleanRupiahFormat(hargaInput.value).trim(),
                kuota: kuotaInput.value.trim(),
                masa_aktif: masaAktifInput.value.trim(),
            };

            // Validasi akhir
            if (Object.values(packageData).some(value => !value)) {
                showAlert("Validasi Gagal", "Mohon lengkapi semua field input sebelum menyimpan data.");
                return;
            }

            // Konversi harga bersih ke integer untuk validasi tambahan jika perlu
            if (isNaN(parseInt(packageData.harga))) {
                showAlert("Validasi Gagal", "Harga harus berupa angka yang valid.");
                return;
            }

            // Tampilkan loading state
            checkButton.disabled = true;
            buttonText.textContent = 'Menyimpan...';
            loader.classList.remove('hidden');
            resultsDiv.innerHTML = ''; // Kosongkan hasil sebelumnya

            // Simulasikan proses simpan/API dengan delay 1.5 detik
            setTimeout(() => {
                try {
                    // Di aplikasi nyata, Anda akan mengirimkan dataPackage ke server/API di sini.

                    // Setelah sukses (simulasi):
                    // Kita kirim harga dalam format Rupiah untuk tampilan konfirmasi
                    renderConfirmation({
                        ...packageData,
                        harga: formatRupiah(packageData.harga) // Format ulang untuk tampilan
                    });

                    // Opsional: kosongkan input setelah simpan sukses
                    // packageNameInput.value = '';
                    // hargaInput.value = '';
                    // kuotaInput.value = '';
                    // masaAktifInput.value = '';
                    // operatorSelect.value = '';

                } catch (error) {
                    console.error("Error during package submission simulation:", error);
                    showAlert("Kesalahan Sistem", "Terjadi kesalahan saat memproses penyimpanan data. Coba lagi.");
                } finally {
                    // Sembunyikan loading state
                    checkButton.disabled = false;
                    buttonText.textContent = 'Simpan Data Paket';
                    loader.classList.add('hidden');
                    validateInput(); // Pastikan tombol kembali ke status validasi
                }

            }, 1500); // 1.5 detik delay simulasi
        }

        /**
         * Menampilkan konfirmasi data yang telah disimpan.
         * @param {Object} pkg Data paket yang disubmit.
         */
        function renderConfirmation(pkg) {
            resultsDiv.innerHTML = `
                <div class="bg-primary/10 border-l-4 border-primary text-green-900 p-4 mb-6 rounded-lg">
                    <p class="font-bold">✅ Data Paket Berhasil Disimpan!</p>
                    <p class="text-sm">Berikut adalah detail yang baru saja Anda masukkan (Simulasi Konfirmasi).</p>
                </div>
                <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-md">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">${pkg.name} (${pkg.operator})</h3>

                    <div class="text-sm text-gray-600 space-y-2">
                        <p class="flex justify-between items-center border-b pb-1"><span class="font-medium text-gray-700">Harga:</span> <span class="text-right font-semibold text-primary">${pkg.harga}</span></p>
                        <p class="flex justify-between items-center border-b pb-1"><span class="font-medium text-gray-700">Kuota:</span> <span class="text-right">${pkg.kuota}</span></p>
                        <p class="flex justify-between items-center"><span class="font-medium text-gray-700">Masa Aktif:</span> <span class="text-right">${pkg.masa_aktif}</span></p>
                    </div>
                </div>
            `;
        }

        // Inisialisasi: memanggil validasi saat halaman dimuat
        window.onload = validateInput;
    </script>
</body>

</html>
