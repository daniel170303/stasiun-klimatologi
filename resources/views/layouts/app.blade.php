<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Stasiun Klimatologi') }} - @yield('title', 'Dashboard')</title>

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
                <h1 class="text-2xl font-semibold text-gray-900">
                    {{ $header }}
                </h1>
            </div>
        </header>
    @endif

    {{-- CONTENT --}}
    <main class="py-10">
        <div class="max-w-7xl mx-auto px-6">

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="mb-6 rounded-lg border border-green-300 bg-green-50 px-5 py-4 text-green-900 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR --}}
            @if(session('error'))
                <div class="mb-6 rounded-lg border border-red-300 bg-red-50 px-5 py-4 text-red-900 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- VALIDATION --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-300 bg-red-50 px-5 py-4 text-red-900 shadow-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- PAGE CONTENT --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                @yield('content')
            </div>

        </div>
    </main>

</div>
</body>
</html>
