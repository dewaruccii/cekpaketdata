<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Kepatuhan Harga Paket Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}" />
    <link rel="apple-touch-icon" type="image/png" sizes="180x180" href="{{ asset('assets/img/logo.png') }}" />
    <style>
        /* Menggunakan font Inter untuk tampilan yang bersih */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
        }

        /* Custom styling untuk animasi loading */
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #10b981;
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
        }
    </style>
    <script>
        // Konfigurasi Tailwind untuk warna kustom
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981',
                        secondary: '#059669',
                        info: '#3b82f6',
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
        <div class="flex items-center space-x-3 mb-6">
            <img src="{{ asset('assets/img/telkomsel-seeklogo.png') }}" width="50" alt="">
            <h1 class="text-3xl font-extrabold text-gray-800">Cek Kepatuhan Harga</h1>
            {{-- <img src="{{ asset('assets/img/logo.png') }}" class="absolute top-2 right-3" width="50" alt=""> --}}
        </div>
        <p class="text-gray-500 mb-8 border-b pb-4">Masukkan detail paket data internet Anda untuk menghitung dan
            memeriksa Price Per Gigabyte (PPGB) terhadap ambang batas kepatuhan.</p>

        <div class="space-y-6">

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

            <button onclick="submitPackage()" id="checkButton"
                class="w-full bg-primary text-white p-4 rounded-xl font-bold text-lg hover:bg-secondary transition duration-300 ease-in-out shadow-lg shadow-primary/30 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                <span id="buttonText">Simpan & Hitung Kepatuhan</span>
                <div id="loader" class="loader ml-3 hidden"></div>
            </button>


        </div>

        <div id="results" class="mt-8">
        </div>
        <div class="text-center mt-4 text-gray-400 text-sm">
            <span>2025 © CPM A2</span>
        </div>

        <div id="alertBox" class="fixed inset-0 bg-gray-900 bg-opacity-70 hidden items-center justify-center z-50 p-4"
            onclick="closeAlert()">
            <div class="bg-white p-6 rounded-2xl shadow-2xl max-w-sm w-full transform transition-all duration-300 scale-100 opacity-100"
                onclick="event.stopPropagation()">
                <div class="flex justify-between items-center mb-3">
                    <h3 id="alertTitle" class="text-xl font-bold text-red-600">Error</h3>
                    {{-- <button onclick="closeAlert()" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button> --}}
                </div>
                <p id="alertMessage" class="text-gray-600 mb-6"></p>
                <button onclick="closeAlert()"
                    class="w-full bg-red-500 text-white p-3 rounded-xl font-semibold hover:bg-red-600 transition shadow-md shadow-red-500/30">Tutup</button>
            </div>
        </div>

        <div id="uploadModal"
            class="fixed inset-0 bg-gray-900 bg-opacity-70 hidden items-center justify-center z-50 p-4"
            onclick="closeModal()">
            <div class="bg-white p-6 rounded-2xl shadow-2xl max-w-lg w-full transform transition-all duration-300 scale-100 opacity-100"
                onclick="event.stopPropagation()">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold text-primary flex items-center">
                        <i data-lucide="cloud-upload" class="w-6 h-6 mr-2"></i> Konfirmasi & Upload Bukti
                    </h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <form id="packageForm" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="modal_operator" name="operator">
                    <input type="hidden" id="modal_harga" name="harga">
                    <input type="hidden" id="modal_kuota_gb" name="kuota_gb">
                    <input type="hidden" id="modal_masa_aktif_hari" name="masa_aktif_hari">
                    <input type="hidden" id="modal_latitude" name="latitude">
                    <input type="hidden" id="modal_longitude" name="longitude">
                    <input type="hidden" id="modal_flag" name="flag">
                    <input type="hidden" id="modal_ppgb" name="ppgb">

                    <div class="mb-5 p-4 border border-dashed border-gray-300 rounded-xl bg-gray-50">
                        <label for="buktiUpload"
                            class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <i data-lucide="image" class="w-4 h-4 mr-2 text-primary"></i> Unggah Bukti (Max 2MB per
                            file, Max 5 file)
                        </label>
                        <input type="file" id="buktiUpload" name="bukti[]" accept="image/jpeg,image/png" multiple
                            required
                            class="w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition duration-150 ease-in-out">
                    </div>

                    <div class="mb-5 p-4 border border-info/50 rounded-xl bg-info/5">
                        <p class="text-sm font-semibold text-info flex items-center mb-2">
                            <i data-lucide="map-pin" class="w-4 h-4 mr-2"></i> Status Lokasi GPS:
                        </p>
                        <div class="flex items-center space-x-2">
                            <div id="locationLoader" class="loader w-4 h-4 mr-2"></div>
                            <span id="locationStatus" class="text-sm text-gray-600 font-medium">Meminta izin
                                lokasi...</span>
                        </div>
                        <p id="locationData" class="text-xs text-gray-500 mt-2 hidden"></p>
                    </div>

                    <button type="submit" id="finalSubmitButton" disabled
                        class="w-full bg-primary text-white p-3 rounded-xl font-bold text-lg hover:bg-secondary transition duration-300 ease-in-out shadow-lg shadow-primary/30 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                        <span id="finalButtonText">Konfirmasi & Kirim Data</span>
                    </button>
                </form>
            </div>
        </div>

        <script>
            // Render Lucide icons
            lucide.createIcons();
        </script>
    </div>

    <script>
        // Deklarasi elemen input
        const operatorSelect = document.getElementById('operator');
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

        // Deklarasi elemen modal
        const uploadModal = document.getElementById('uploadModal');
        const locationStatus = document.getElementById('locationStatus');
        const locationLoader = document.getElementById('locationLoader');
        const locationDataEl = document.getElementById('locationData');
        const finalSubmitButton = document.getElementById('finalSubmitButton');
        const finalButtonText = document.getElementById('finalButtonText');


        // Data PPGB Minimum berdasarkan Harga Bulanan
        const MIN_PPGB_THRESHOLDS = [{
                maxPrice: 34000,
                minPPGB: 4
            },
            {
                maxPrice: 39000,
                minPPGB: 3.5
            },
            {
                maxPrice: 49000,
                minPPGB: 3
            },
            {
                maxPrice: 59000,
                minPPGB: 2.5
            },
            {
                maxPrice: 69000,
                minPPGB: 2.25
            },
            {
                maxPrice: 79000,
                minPPGB: 2
            },
            {
                maxPrice: 89000,
                minPPGB: 2
            },
            {
                maxPrice: 99000,
                minPPGB: 1.8
            },
            {
                maxPrice: 109000,
                minPPGB: 1.5
            },
            {
                maxPrice: 119000,
                minPPGB: 1.5
            },
            {
                maxPrice: 149000,
                minPPGB: 1.5
            },
            {
                maxPrice: 200000,
                minPPGB: 1.0
            },
            {
                maxPrice: Infinity,
                minPPGB: 0.56
            }
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
            lucide.createIcons();
        }

        function closeAlert() {
            alertBox.classList.add('hidden');
            alertBox.classList.remove('flex');
        }

        function closeModal() {
            $(uploadModal).removeClass('flex').addClass('hidden');
            // Reset state modal
            $('#locationStatus').text('Meminta izin lokasi...');
            $('#locationLoader').removeClass('hidden');
            $('#locationData').addClass('hidden').text('');
            $('#modal_latitude').val('');
            $('#modal_longitude').val('');
            $('#finalSubmitButton').prop('disabled', true);
            // Hapus hasil perhitungan sementara (HANYA HAPUS jika ada rencana reset total)
            // resultsDiv.innerHTML = '';
            // Reset input file
            $('#buktiUpload').val('');
        }

        function cleanRupiahFormat(value) {
            if (value === null || value === undefined) {
                value = '';
            }
            return String(value).replace(/[^,\d]/g, '').replace(/,/g, '');
        }

        function formatRupiah(amount) {
            if (amount === null || amount === undefined) {
                amount = '';
            }

            let number_string = cleanRupiahFormat(amount).toString();
            if (!number_string) return '';

            let sisa = number_string.length % 3;
            let rupiah = number_string.substr(0, sisa);
            let ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return rupiah;
        }

        function extractNumericGB(value) {
            const match = String(value).match(/(\d+(\.\d+)?)/);
            return match ? parseFloat(match[1]) : NaN;
        }

        function extractNumericDays(value) {
            const valueStr = String(value);
            const daysMatch = valueStr.match(/(\d+)\s*(hari|day|days)/i);
            if (daysMatch) return parseInt(daysMatch[1]);

            const monthMatch = valueStr.match(/(\d+)\s*(bulan|month|months)/i);
            if (monthMatch) return parseInt(monthMatch[1]) * 30;

            const simpleNumberMatch = valueStr.match(/^\s*(\d+)\s*$/);
            if (simpleNumberMatch) return parseInt(simpleNumberMatch[1]);

            return NaN;
        }

        // --- Calculation Logic ---

        function getMinPPGB(monthlyPrice) {
            for (const threshold of MIN_PPGB_THRESHOLDS) {
                if (monthlyPrice <= threshold.maxPrice) {
                    return threshold.minPPGB;
                }
            }
            return 2;
        }

        function calculateCompliance(price, days, gb) {
            let monthlyPrice = 0;
            let ppgb = 0;
            let minPPGB = 0;
            let flag = "ERROR";

            if (days > 0 && gb > 0) {
                monthlyPrice = price * (30 / days);
                ppgb = (monthlyPrice / gb) / 1000;
                minPPGB = getMinPPGB(monthlyPrice);

                if (price < 6000) {
                    flag = "NON COMPLY";
                    ppgb = (price / gb) / 1000;
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
            } else {
                flag = "INVALID INPUT";
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
            const hargaNumeric = cleanRupiahFormat(hargaInput.value).trim();
            const kuotaGB = extractNumericGB(kuotaInput.value);
            const masaAktifDays = extractNumericDays(masaAktifInput.value);

            const isPriceValid = hargaNumeric && !isNaN(parseInt(hargaNumeric));
            const isKuotaValid = !isNaN(kuotaGB) && kuotaGB > 0;
            const isDaysValid = !isNaN(masaAktifDays) && masaAktifDays > 0;

            if (operator && isPriceValid && isKuotaValid && isDaysValid) {
                checkButton.disabled = false;
            } else {
                checkButton.disabled = true;
            }
        }

        // Event listeners untuk input utama
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

        operatorSelect.addEventListener('change', validateInput);
        kuotaInput.addEventListener('input', validateInput);
        masaAktifInput.addEventListener('input', validateInput);


        /**
         * Fungsi untuk mengambil Geolocation.
         */
        function getGeolocation(calculation) {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;

                        $('#modal_latitude').val(lat);
                        $('#modal_longitude').val(lon);

                        // Update status di modal
                        $(locationLoader).addClass('hidden');
                        $(locationStatus).html(
                            '<i data-lucide="check" class="w-4 h-4 mr-1 text-primary inline"></i> Lokasi Berhasil Diambil'
                        );
                        $(locationDataEl).removeClass('hidden').text(`Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}`);
                        $(finalSubmitButton).prop('disabled', false);
                        lucide.createIcons();

                        // Tampilkan hasil perhitungan sementara di background
                        renderConfirmation({
                            operator: operatorSelect.value,
                            harga: parseInt(cleanRupiahFormat(hargaInput.value).trim()),
                            kuota_raw: kuotaInput.value.trim(),
                            masa_aktif_raw: masaAktifInput.value.trim(),
                            kuota_gb: extractNumericGB(kuotaInput.value),
                            masa_aktif_hari: extractNumericDays(masaAktifInput.value)
                        }, calculation);
                    },
                    function(error) {
                        let errorMessage;
                        if (error.code === error.PERMISSION_DENIED) {
                            errorMessage = "Izin lokasi DITOLAK. Harap izinkan akses lokasi untuk melanjutkan.";
                        } else if (error.code === error.POSITION_UNAVAILABLE) {
                            errorMessage = "Informasi lokasi tidak tersedia.";
                        } else if (error.code === error.TIMEOUT) {
                            errorMessage = "Waktu tunggu pengambilan lokasi habis (Timeout).";
                        } else {
                            errorMessage = "Terjadi kesalahan yang tidak diketahui saat mengambil lokasi.";
                        }

                        $(locationLoader).addClass('hidden');
                        $(locationStatus).html(
                            '<i data-lucide="alert-triangle" class="w-4 h-4 mr-1 text-danger inline"></i> Gagal Mendapat Lokasi: ' +
                            errorMessage);
                        $(finalSubmitButton).prop('disabled', true);
                        lucide.createIcons();

                        showAlert("Gagal Geolocation", errorMessage);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                $(locationLoader).addClass('hidden');
                $(locationStatus).html(
                    '<i data-lucide="alert-circle" class="w-4 h-4 mr-1 text-danger inline"></i> Browser tidak mendukung Geolocation.'
                );
                $(finalSubmitButton).prop('disabled', true);
                lucide.createIcons();
            }
        }

        /**
         * Fungsi utama untuk menampilkan modal dan meminta lokasi.
         */
        function submitPackage() {
            const price = parseInt(cleanRupiahFormat(hargaInput.value).trim());
            const gb = extractNumericGB(kuotaInput.value);
            const days = extractNumericDays(masaAktifInput.value);

            if (isNaN(price) || isNaN(gb) || isNaN(days) || price <= 0 || gb <= 0 || days <= 0) {
                showAlert("Validasi Gagal",
                    "Pastikan Harga, Kuota (GB), dan Masa Aktif (Hari) diisi dengan angka yang valid dan lebih dari nol."
                );
                return;
            }

            const calculation = calculateCompliance(price, days, gb);

            // 1. Tampilkan Modal
            $(uploadModal).removeClass('hidden').addClass('flex');
            lucide.createIcons();

            // 2. Isi Hidden Input Modal dengan data paket & perhitungan
            $('#modal_operator').val(operatorSelect.value);
            $('#modal_harga').val(price);
            $('#modal_kuota_gb').val(gb);
            $('#modal_masa_aktif_hari').val(days);
            $('#modal_flag').val(calculation.flag);
            $('#modal_ppgb').val(calculation.ppgb.toFixed(2));

            // Reset status lokasi
            $('#modal_latitude').val('');
            $('#modal_longitude').val('');
            $(locationStatus).text('Meminta izin lokasi...');
            $(locationLoader).removeClass('hidden');
            $(locationDataEl).addClass('hidden').text('');
            $(finalSubmitButton).prop('disabled', true);

            // 3. Panggil Geolocation
            getGeolocation(calculation);
        }

        /**
         * Handler untuk form submission (AJAX) di dalam modal.
         */
        $('#packageForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const files = $('#buktiUpload')[0].files;
            const MAX_FILE_SIZE = 2097152; // 2MB
            const MAX_TOTAL_FILES = 5;

            // 1. Validasi File
            if (files.length === 0) {
                showAlert("Validasi Upload", "Harap unggah minimal satu bukti foto.", false);
                return;
            }
            if (files.length > MAX_TOTAL_FILES) {
                showAlert("Validasi Upload", `Jumlah file melebihi batas (${MAX_TOTAL_FILES} file).`, false);
                return;
            }

            for (let i = 0; i < files.length; i++) {
                if (files[i].size > MAX_FILE_SIZE) {
                    showAlert("Validasi File", `Ukuran file ke-${i + 1} (${files[i].name}) melebihi batas 2MB.`,
                        false);
                    return;
                }
            }

            // --- AMBIL DATA DARI HIDDEN INPUT UNTUK DITAMPILKAN NANTI (SETELAH SUKSES) ---
            const packageData = {
                operator: $('#modal_operator').val(),
                harga: parseInt($('#modal_harga').val()),
                kuota_gb: parseFloat($('#modal_kuota_gb').val()),
                masa_aktif_hari: parseInt($('#modal_masa_aktif_hari').val()),
                kuota_raw: kuotaInput.value.trim(),
                masa_aktif_raw: masaAktifInput.value.trim(),
            };
            const calculation = {
                // Hitung ulang monthly price untuk renderConfirmation
                monthlyPrice: packageData.harga * (30 / packageData.masa_aktif_hari),
                ppgb: parseFloat($('#modal_ppgb').val()),
                minPPGB: getMinPPGB(packageData.harga * (30 / packageData.masa_aktif_hari)),
                flag: $('#modal_flag').val()
            };
            // --------------------------------------------------------------------------

            // Tampilkan loading saat proses AJAX
            $(finalSubmitButton).prop('disabled', true);
            $(finalButtonText).text('Mengirim Data...');

            // Panggil AJAX
            $.ajax({
                url: '{{ route('check') }}', // Sesuaikan dengan route name Anda: package.store
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // 1. Tutup Modal
                    closeModal();

                    // 2. Tampilkan Hasil di bawah form utama
                    renderConfirmation(packageData, calculation);

                    // 3. Tampilkan Alert Sukses
                    showAlert("Sukses! 🎉",
                        "Data paket, lokasi, dan bukti berhasil disimpan di server. " + (response
                            .message || ''), false);

                    // 4. Reset form input utama agar siap untuk input baru
                    $('#packageForm')[0].reset();
                    $('#operator').val('');
                    $('#buktiUpload').val('');
                    validateInput();

                },
                error: function(xhr, status, error) {
                    closeModal();
                    let msg = "Terjadi kesalahan saat mengirim data ke server. Coba lagi.";
                    try {
                        const responseJson = JSON.parse(xhr.responseText);
                        // Ambil error message dari response JSON (khusus Laravel 422 errors)
                        if (xhr.status === 422 && responseJson.errors) {
                            const errorKeys = Object.keys(responseJson.errors);
                            msg = responseJson.errors[errorKeys[0]][0]; // Ambil error pertama
                        } else {
                            msg = responseJson.message || xhr.statusText || msg;
                        }
                    } catch (e) {
                        msg = "Server Error atau Koneksi Gagal (" + xhr.status + ").";
                    }
                    showAlert("Gagal Kirim Data ❌", msg);
                },
                complete: function() {
                    $(finalButtonText).text('Konfirmasi & Kirim Data');
                    if ($('#modal_latitude').val() && $('#modal_longitude').val()) {
                        $(finalSubmitButton).prop('disabled', false);
                    }
                }
            });
        });


        /**
         * Menampilkan konfirmasi data dan hasil perhitungan di resultsDiv.
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
                            <span class="font-bold text-blue-600">${calc.ppgb.toFixed(2)} </span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-600">PPGB Minimum (Ambang Batas):</span>
                            <span class="font-bold text-gray-800">${calc.minPPGB.toFixed(2)} </span>
                        </div>
                    </div>

                    <div class="mt-6 p-4 text-center rounded-xl font-extrabold text-white text-xl shadow-lg ring-4 ${flagBg} ${flagRing}">
                        <span class="uppercase">${flagText}</span>
                    </div>
                </div>
            `;
            lucide.createIcons();
        }

        // Inisialisasi: memanggil validasi saat halaman dimuat
        window.onload = () => {
            validateInput();
            if (hargaInput.value) {
                hargaInput.value = formatRupiah(hargaInput.value);
            }
        };
    </script>
</body>

</html>
