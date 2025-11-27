<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Aplikasi</title>
    <!-- Memuat Tailwind CSS dari CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Konfigurasi Font Inter -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            /* Latar belakang abu-abu terang */
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-4">

    <!-- Kontainer Kartu Login Utama -->
    <div
        class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 md:p-10 transform transition duration-500 hover:shadow-3xl">

        <!-- Header -->
        <div class="text-center mb-8">
            <svg class="mx-auto h-12 w-12 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-1a3 3 0 013-3h12a3 3 0 013 3z" />
            </svg>
            <h1 class="mt-4 text-3xl font-extrabold text-gray-900">
                Selamat Datang Kembali
            </h1>
            <p class="mt-2 text-sm text-gray-500">
                Silakan masuk untuk melanjutkan
            </p>
        </div>

        <!-- Formulir Login -->
        <form id="loginForm" action="{{ route('auth.login') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Area Pesan (untuk menampilkan error/sukses) -->
            <div id="messageArea" class="hidden p-3 rounded-lg text-sm transition-all duration-300"></div>

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="email" id="email" name="email" required placeholder="anda@contoh.com"
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                        autocomplete="email">
                </div>
                @error('email')
                    <small class="text-red-700 italic">{{ $message }}</small>
                @enderror
            </div>

            <!-- Input Kata Sandi -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter"
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                        autocomplete="current-password">
                </div>
                @error('password')
                    <small class="text-red-700 italic">{{ $message }}</small>
                @enderror
            </div>

            {{-- <!-- Tombol Lupa Kata Sandi (Opsional) -->
            <div class="flex items-center justify-end">
                <a href="#"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out">
                    Lupa kata sandi Anda?
                </a>
            </div> --}}

            <!-- Tombol Submit -->
            <div>
                <button type="submit" id="loginButton"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="buttonText">Masuk</span>
                    <svg id="spinner" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Pendaftaran (Register) -->
        {{-- <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="#"
                    class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out">
                    Daftar sekarang
                </a>
            </p>
        </div> --}}
    </div>

    <!-- Logika JavaScript untuk Simulasi Login -->

</body>

</html>
