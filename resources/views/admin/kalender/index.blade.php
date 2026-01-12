@extends('layouts.app')

@section('title', 'Kalender Kunjungan')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Kalender Kunjungan</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.export.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Laporan
            </a>
        </div>
    </div>

    <!-- View Switcher & Navigation -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
            <!-- Navigation -->
            <div class="flex items-center gap-4">
                @if($view === 'month')
                    <a href="?view={{ $view }}&date={{ $currentDate->copy()->subMonth()->format('Y-m-d') }}" class="p-2 hover:bg-gray-100 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <h2 class="text-xl font-semibold">{{ $currentDate->format('F Y') }}</h2>
                    <a href="?view={{ $view }}&date={{ $currentDate->copy()->addMonth()->format('Y-m-d') }}" class="p-2 hover:bg-gray-100 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <a href="?view={{ $view }}&date={{ $currentDate->copy()->subWeek()->format('Y-m-d') }}" class="p-2 hover:bg-gray-100 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <h2 class="text-xl font-semibold">{{ $startDate->format('d M') }} - {{ $endDate->format('d M Y') }}</h2>
                    <a href="?view={{ $view }}&date={{ $currentDate->copy()->addWeek()->format('Y-m-d') }}" class="p-2 hover:bg-gray-100 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
                
                <a href="?view={{ $view }}&date={{ now()->format('Y-m-d') }}" class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 text-sm">
                    Hari Ini
                </a>
            </div>

            <!-- View Toggle -->
            <div class="flex gap-2">
                <a href="?view=month&date={{ $currentDate->format('Y-m-d') }}" class="px-4 py-2 rounded {{ $view === 'month' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Bulanan
                </a>
                <a href="?view=week&date={{ $currentDate->format('Y-m-d') }}" class="px-4 py-2 rounded {{ $view === 'week' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Mingguan
                </a>
            </div>
        </div>

        @if($view === 'month')
            @include('admin.kalender.partials.month-view')
        @else
            @include('admin.kalender.partials.week-view')
        @endif
    </div>

    <!-- Legend -->
    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="font-semibold mb-3">Keterangan Status:</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #3B82F6;"></div>
                <span class="text-sm">Diajukan</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #EAB308;"></div>
                <span class="text-sm">Menunggu Konfirmasi</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #8B5CF6;"></div>
                <span class="text-sm">Dikonfirmasi</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #EC4899;"></div>
                <span class="text-sm">Petugas Ditugaskan</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #10B981;"></div>
                <span class="text-sm">Terlaksana</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #EF4444;"></div>
                <span class="text-sm">Tidak Terlaksana</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded" style="background-color: #6B7280;"></div>
                <span class="text-sm">Selesai</span>
            </div>
        </div>
    </div>
</div>
@endsection