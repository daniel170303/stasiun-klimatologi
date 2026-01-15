<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stasiun Klimatologi IV</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    
    <!-- Navigation - Sticky with backdrop blur -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg transform hover:scale-110 transition duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-gray-900">Stasiun Klimatologi IV</span>
                        <p class="text-xs text-gray-500">BMKG Indonesia</p>
                    </div>
                </div>
                
                @if (Route::has('login'))
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-gray-700 hover:text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-gray-700 hover:text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                            Daftar Sekarang
                        </a>
                        @endif
                    @endauth
                </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section - Enhanced with better spacing -->
    <div class="relative overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 float-animation"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 float-animation" style="animation-delay: 2s;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32 relative">
            <div class="text-center">
                <div class="inline-block mb-6">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-700">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                        </svg>
                        Sistem Digital Terpercaya
                    </span>
                </div>

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 mb-6 leading-tight">
                    Sistem Penjadwalan<br/>
                    <span class="gradient-text">Kunjungan Online</span>
                </h1>
                
                <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                    Platform digital resmi untuk mengajukan dan mengelola jadwal kunjungan ke Stasiun Klimatologi IV BMKG dengan mudah, cepat, dan efisien.
                </p>
                
                @guest
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-8">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition duration-200 shadow-xl hover:shadow-2xl">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Ajukan Kunjungan
                        </span>
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-indigo-600 rounded-xl font-semibold hover:bg-gray-50 border-2 border-indigo-200 hover:border-indigo-300 transition duration-200 shadow-lg hover:shadow-xl">
                        Masuk ke Akun
                    </a>
                </div>
                @endguest

                <!-- Stats Section -->
                <div class="grid grid-cols-3 gap-6 max-w-2xl mx-auto mt-16">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-indigo-600 mb-2">100+</div>
                        <div class="text-sm text-gray-600">Instansi Terdaftar</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">500+</div>
                        <div class="text-sm text-gray-600">Kunjungan Sukses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-pink-600 mb-2">24/7</div>
                        <div class="text-sm text-gray-600">Akses Sistem</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section - Improved layout -->
    <div class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-700 mb-4">
                    Mengapa Memilih Kami
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Kemudahan dan efisiensi dalam setiap langkah proses kunjungan Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group bg-gradient-to-br from-white to-indigo-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-indigo-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pengajuan Online</h3>
                    <p class="text-gray-600 leading-relaxed">Ajukan kunjungan kapan saja, di mana saja dengan upload surat permohonan secara digital tanpa harus datang langsung</p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-gradient-to-br from-white to-green-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-green-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Notifikasi Real-time</h3>
                    <p class="text-gray-600 leading-relaxed">Dapatkan notifikasi email otomatis untuk setiap perubahan status pengajuan kunjungan Anda secara langsung</p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-gradient-to-br from-white to-pink-50 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-pink-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300 shadow-lg">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Petugas Profesional</h3>
                    <p class="text-gray-600 leading-relaxed">Didampingi oleh petugas ahli di bidang klimatologi yang berpengalaman dan siap membantu Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Process Section - Enhanced visualization -->
    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-white text-indigo-700 mb-4 shadow-sm">
                    Panduan Langkah
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Alur Proses Kunjungan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Empat langkah mudah untuk mengajukan kunjungan ke Stasiun Klimatologi IV</p>
            </div>

            <div class="relative">
                <!-- Connection line for desktop -->
                <div class="absolute top-12 left-0 right-0 h-1 bg-gradient-to-r from-indigo-200 via-purple-200 to-pink-200 hidden md:block"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-6 relative">
                    <!-- Step 1 -->
                    <div class="text-center fade-in">
                        <div class="relative inline-block mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-xl relative z-10">
                                1
                            </div>
                            <div class="absolute inset-0 bg-indigo-400 rounded-full blur-xl opacity-50"></div>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-lg">
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Registrasi Akun</h3>
                            <p class="text-sm text-gray-600">Buat akun baru dan lengkapi data instansi Anda dengan benar</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center fade-in" style="animation-delay: 0.1s;">
                        <div class="relative inline-block mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-xl relative z-10">
                                2
                            </div>
                            <div class="absolute inset-0 bg-purple-400 rounded-full blur-xl opacity-50"></div>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-lg">
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Ajukan Kunjungan</h3>
                            <p class="text-sm text-gray-600">Upload surat resmi dan pilih tanggal kunjungan yang diinginkan</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center fade-in" style="animation-delay: 0.2s;">
                        <div class="relative inline-block mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-pink-600 to-rose-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-xl relative z-10">
                                3
                            </div>
                            <div class="absolute inset-0 bg-pink-400 rounded-full blur-xl opacity-50"></div>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-lg">
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Verifikasi Admin</h3>
                            <p class="text-sm text-gray-600">Tim admin akan memverifikasi dan mengonfirmasi jadwal Anda</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center fade-in" style="animation-delay: 0.3s;">
                        <div class="relative inline-block mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-xl relative z-10">
                                4
                            </div>
                            <div class="absolute inset-0 bg-green-400 rounded-full blur-xl opacity-50"></div>
                        </div>
                        <div class="bg-white rounded-xl p-6 shadow-lg">
                            <h3 class="font-bold text-gray-900 mb-2 text-lg">Laksanakan Kunjungan</h3>
                            <p class="text-sm text-gray-600">Datang sesuai jadwal yang telah disetujui oleh admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section - Inline instead of popup -->
    <div class="bg-white py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-700 mb-4">
                    Pertanyaan Umum
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">FAQ & Bantuan</h2>
                <p class="text-lg text-gray-600">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
            </div>

            <div class="space-y-4 mb-10">
                <!-- FAQ ITEM 1 -->
                <div class="border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-indigo-300 transition">
                    <button onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-6 py-5 font-semibold text-gray-800 hover:bg-gray-50 transition text-left">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Siapa saja yang dapat mengajukan kunjungan?
                        </span>
                        <span class="text-2xl text-indigo-600 transition-transform font-bold">+</span>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600 bg-gray-50">
                        Pengajuan kunjungan dapat dilakukan oleh sekolah, perguruan tinggi, instansi pemerintah, organisasi, maupun masyarakat umum sesuai ketentuan yang berlaku.
                    </div>
                </div>

                <!-- FAQ ITEM 2 -->
                <div class="border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-indigo-300 transition">
                    <button onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-6 py-5 font-semibold text-gray-800 hover:bg-gray-50 transition text-left">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Apakah harus memiliki akun untuk mengajukan kunjungan?
                        </span>
                        <span class="text-2xl text-indigo-600 transition-transform font-bold">+</span>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600 bg-gray-50">
                        Ya, sangat diperlukan. Pengunjung wajib melakukan registrasi akun terlebih dahulu untuk dapat mengajukan permohonan dan memantau status kunjungan secara real-time.
                    </div>
                </div>

                <!-- FAQ ITEM 3 -->
                <div class="border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-indigo-300 transition">
                    <button onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-6 py-5 font-semibold text-gray-800 hover:bg-gray-50 transition text-left">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Dokumen apa yang perlu disiapkan?
                        </span>
                        <span class="text-2xl text-indigo-600 transition-transform font-bold">+</span>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600 bg-gray-50">
                        Dokumen utama yang diperlukan adalah surat permohonan kunjungan resmi dari instansi dalam format PDF atau gambar yang diunggah melalui sistem.
                    </div>
                </div>

                <!-- FAQ ITEM 4 -->
                <div class="border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-indigo-300 transition">
                    <button onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-6 py-5 font-semibold text-gray-800 hover:bg-gray-50 transition text-left">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Berapa lama proses verifikasi pengajuan?
                        </span>
                        <span class="text-2xl text-indigo-600 transition-transform font-bold">+</span>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600 bg-gray-50">
                        Proses verifikasi membutuhkan waktu sekitar 1–3 hari kerja tergantung kelengkapan dokumen dan ketersediaan jadwal stasiun.
                    </div>
                </div>

                <!-- FAQ ITEM 5 -->
                <div class="border-2 border-gray-200 rounded-2xl overflow-hidden hover:border-indigo-300 transition">
                    <button onclick="toggleAccordion(this)"
                        class="w-full flex justify-between items-center px-6 py-5 font-semibold text-gray-800 hover:bg-gray-50 transition text-left">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Bagaimana jika mengalami kendala teknis?
                        </span>
                        <span class="text-2xl text-indigo-600 transition-transform font-bold">+</span>
                    </button>
                    <div class="hidden px-6 pb-5 text-gray-600 bg-gray-50">
                        Silakan hubungi admin melalui WhatsApp resmi yang tersedia apabila mengalami kendala teknis dalam penggunaan sistem.
                    </div>
                </div>
            </div>

            <!-- WHATSAPP Contact Card -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-8 text-center shadow-lg">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.52 3.48A11.91 11.91 0 0012.05 0C5.5 0 .2 5.3.2 11.85c0 2.1.55 4.15 1.6 5.95L0 24l6.4-1.7a11.85 11.85 0 005.65 1.45h.05c6.55 0 11.85-5.3 11.85-11.85 0-3.15-1.25-6.1-3.43-8.42z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                    Butuh Bantuan?
                </h3>
                <p class="text-gray-600 mb-6">
                    Hubungi kami melalui WhatsApp untuk informasi lebih lanjut atau bantuan teknis
                </p>
                <a href="https://wa.me/6281234567890" target="_blank"
                   class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-green-500 text-white rounded-xl font-semibold hover:bg-green-600 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.52 3.48A11.91 11.91 0 0012.05 0C5.5 0 .2 5.3.2 11.85c0 2.1.55 4.15 1.6 5.95L0 24l6.4-1.7a11.85 11.85 0 005.65 1.45h.05c6.55 0 11.85-5.3 11.85-11.85 0-3.15-1.25-6.1-3.43-8.42z"/>
                    </svg>
                    Hubungi via WhatsApp
                </a>
                <div class="mt-4 pt-4 border-t border-green-200">
                    <p class="text-sm text-gray-500 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Jam operasional: Senin – Jumat (08.00 – 16.00 WIB)
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    @guest
    <div class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl shadow-2xl overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
                    <div class="absolute bottom-10 right-10 w-40 h-40 bg-white rounded-full"></div>
                </div>
                
                <div class="relative px-8 py-16 md:py-20 text-center">
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">
                        Siap Mengajukan Kunjungan?
                    </h2>
                    <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto">
                        Bergabunglah dengan ratusan instansi yang telah mempercayai sistem kami untuk mengatur jadwal kunjungan
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-indigo-600 rounded-xl font-semibold hover:bg-gray-50 transform hover:scale-105 transition duration-200 shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Daftar Sekarang - Gratis!
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 text-white border-2 border-white rounded-xl font-semibold hover:bg-white/10 transition duration-200">
                            Sudah Punya Akun? Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endguest

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6281234567890" target="_blank"
       class="fixed bottom-6 right-6 z-50 w-16 h-16 rounded-full bg-green-500 shadow-2xl flex items-center justify-center text-white hover:scale-110 hover:bg-green-600 transition duration-300 group">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20.52 3.48A11.91 11.91 0 0012.05 0C5.5 0 .2 5.3.2 11.85c0 2.1.55 4.15 1.6 5.95L0 24l6.4-1.7a11.85 11.85 0 005.65 1.45h.05c6.55 0 11.85-5.3 11.85-11.85 0-3.15-1.25-6.1-3.43-8.42z"/>
        </svg>
        <span class="absolute right-full mr-3 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition whitespace-nowrap shadow-lg">
            Hubungi Kami
        </span>
    </a>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- About -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                        </div>
                        <span class="text-lg font-bold">Stasiun Klimatologi IV</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Sistem digital untuk mengajukan dan mengelola jadwal kunjungan ke Stasiun Klimatologi IV BMKG.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition">Daftar Akun</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Masuk</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Panduan Penggunaan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Kontak</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Jl. Klimatologi No. 1, Kota</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>stasiun.klimatologi@bmkg.go.id</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>(021) 1234-5678</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Stasiun Klimatologi IV BMKG. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>

    <script>
        function toggleAccordion(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('span:last-child');

            content.classList.toggle('hidden');
            icon.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(45deg)';
        }
    </script>
</body>
</html>