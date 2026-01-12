<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stasiun Klimatologi IV</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-900">Stasiun Klimatologi IV</span>
                    </div>
                </div>
                
                @if (Route::has('login'))
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 font-medium">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-150 shadow-md">
                            Daftar
                        </a>
                        @endif
                    @endauth
                </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 mb-6">
                    Sistem Penjadwalan
                    <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Kunjungan
                    </span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Platform digital untuk mengajukan dan mengelola jadwal kunjungan ke Stasiun Klimatologi IV dengan mudah dan efisien.
                </p>
                
                @guest
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition duration-150 shadow-xl">
                        Ajukan Kunjungan
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-indigo-600 rounded-xl font-semibold hover:bg-gray-50 border-2 border-indigo-600 transform hover:scale-105 transition duration-150 shadow-lg">
                        Masuk
                    </a>
                </div>
                @endguest
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
            <p class="text-gray-600">Kemudahan dalam setiap langkah proses kunjungan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pengajuan Online</h3>
                <p class="text-gray-600">Ajukan kunjungan kapan saja dengan upload surat permohonan secara digital</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-teal-500 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Notifikasi Real-time</h3>
                <p class="text-gray-600">Dapatkan notifikasi email untuk setiap perubahan status pengajuan kunjungan</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Petugas Profesional</h3>
                <p class="text-gray-600">Didampingi oleh petugas ahli di bidang klimatologi yang berpengalaman</p>
            </div>
        </div>
    </div>

    <!-- Process Section -->
    <div class="bg-white py-16 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Alur Proses Kunjungan</h2>
                <p class="text-gray-600">Proses yang mudah dan terstruktur</p>
            </div>

            <div class="relative">
                <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-gray-200 -translate-y-1/2 hidden md:block"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-lg">
                            1
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Registrasi</h3>
                        <p class="text-sm text-gray-600">Buat akun dan lengkapi data instansi</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-lg">
                            2
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Ajukan Kunjungan</h3>
                        <p class="text-sm text-gray-600">Upload surat dan pilih tanggal</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-lg">
                            3
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Verifikasi</h3>
                        <p class="text-sm text-gray-600">Admin verifikasi dan konfirmasi jadwal</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-lg">
                            4
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Kunjungan</h3>
                        <p class="text-sm text-gray-600">Datang sesuai jadwal yang disetujui</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    @guest
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl shadow-2xl overflow-hidden">
            <div class="px-8 py-16 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Siap Mengajukan Kunjungan?
                </h2>
                <p class="text-xl text-indigo-100 mb-8">
                    Daftar sekarang dan mulai proses pengajuan kunjungan Anda
                </p>
                <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-indigo-600 rounded-xl font-semibold hover:bg-gray-50 transform hover:scale-105 transition duration-150 shadow-xl">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
    @endguest

    <!-- Footer -->
    <footer class="bg-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; {{ date('Y') }} Stasiun Klimatologi IV. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Floating FAQ Button -->
<div class="fixed bottom-6 right-6 z-50">
    <button onclick="toggleFaq()"
        class="w-14 h-14 rounded-full bg-gradient-to-r from-green-500 to-emerald-600 shadow-xl flex items-center justify-center text-white hover:scale-110 transition">
        <!-- Icon Chat -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 10h8m-8 4h5m-9 6l-2-2V5a2 2 0 012-2h16a2 2 0 012 2v11a2 2 0 01-2 2H7z"/>
        </svg>
    </button>
</div>
<!-- FAQ Popup -->
<div id="faqPopup"
     class="fixed inset-0 bg-black/50 hidden items-end md:items-center justify-center z-50">
    
    <div class="bg-white rounded-t-3xl md:rounded-3xl w-full md:w-[420px] p-6 shadow-2xl animate-fade-in">
        
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">FAQ & Bantuan</h3>
            <button onclick="toggleFaq()" class="text-gray-400 hover:text-gray-600 text-2xl">
                &times;
            </button>
        </div>

        <div class="space-y-4 text-gray-600">
            <p>
                Jika Anda mengalami kendala atau membutuhkan informasi lebih lanjut
                terkait pengajuan kunjungan, silakan hubungi kami melalui WhatsApp.
            </p>

            <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                <p class="font-semibold text-gray-800 mb-2">
                    WhatsApp Resmi BMKG
                </p>
                <a href="https://wa.me/6281234567890"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-5 py-3 bg-green-500 text-white rounded-xl font-semibold hover:bg-green-600 transition shadow">
                    <!-- WA Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                         viewBox="0 0 24 24">
                        <path
                            d="M20.52 3.48A11.91 11.91 0 0012.05 0C5.5 0 .2 5.3.2 11.85c0 2.1.55 4.15 1.6 5.95L0 24l6.4-1.7a11.85 11.85 0 005.65 1.45h.05c6.55 0 11.85-5.3 11.85-11.85 0-3.15-1.25-6.1-3.43-8.42z" />
                    </svg>
                    Hubungi via WhatsApp
                </a>

                <p class="text-sm mt-2 text-gray-500">
                    Jam operasional: Senin – Jumat (08.00 – 16.00 WIB)
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFaq() {
        const popup = document.getElementById('faqPopup');
        popup.classList.toggle('hidden');
        popup.classList.toggle('flex');
    }
</script>


</body>
</html>