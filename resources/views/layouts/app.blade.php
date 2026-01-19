<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Stasiun Klimatologi Kelas IV Yogyakarta - @yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/Logo_BMKG.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-100 text-gray-900">
<div class="min-h-screen">

    {{-- NAVBAR --}}
    @include('layouts.navigation')

    {{-- HEADER --}}
    @if (isset($header))
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto py-5 px-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo_BMKG.png') }}" alt="Logo BMKG" class="h-10 w-10">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        {{ $header }}
                    </h1>
                </div>
            </div>
        </header>
    @endif

    {{-- CONTENT --}}
    <main class="py-10">
        <div class="max-w-7xl mx-auto px-6">

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="mb-6 rounded-lg border border-green-300 bg-green-50 px-5 py-4 text-green-900 shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- ERROR --}}
            @if(session('error'))
                <div class="mb-6 rounded-lg border border-red-300 bg-red-50 px-5 py-4 text-red-900 shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- VALIDATION --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-300 bg-red-50 px-5 py-4 text-red-900 shadow-sm">
                    <div class="flex items-start gap-2">
                        <svg class="h-5 w-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- PAGE CONTENT --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                @yield('content')
            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo_BMKG.png') }}" alt="Logo BMKG" class="h-12 w-12">
                    <div class="text-sm">
                        <p class="font-semibold text-gray-900">Stasiun Klimatologi Kelas IV Yogyakarta</p>
                        <p class="text-gray-600">Badan Meteorologi, Klimatologi, dan Geofisika</p>
                    </div>
                </div>
                <div class="text-sm text-gray-600">
                    © {{ date('Y') }} BMKG. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

</div>
</body>
</html>