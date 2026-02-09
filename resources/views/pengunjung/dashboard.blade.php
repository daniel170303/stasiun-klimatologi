@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Pengunjung</h1>
        <a href="{{ route('pengunjung.kunjungan.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Ajukan Kunjungan Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Kunjungan</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $totalKunjungan }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Diajukan</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $kunjunganDiajukan }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Terlaksana</dt>
                            <dd class="text-2xl font-semibold text-gray-900">{{ $kunjunganTerlaksana }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Kalender -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Kalender Kunjungan</h2>
            <div id="calendar-container" class="mb-4"></div>
            <div class="flex items-center gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-red-500 rounded"></div>
                    <span class="text-gray-600">Tanggal Terisi</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 bg-gray-200 rounded"></div>
                    <span class="text-gray-600">Tanggal Tersedia</span>
                </div>
            </div>
        </div>

        <!-- Kunjungan Terbaru -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Kunjungan Terbaru</h2>
                <a href="{{ route('pengunjung.kunjungan.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Lihat Semua →
                </a>
            </div>

        <div class="space-y-4">
            @forelse($kunjunganTerbaru as $kunjungan)
            <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-2 py-1 text-xs rounded-full {{ $kunjungan->status->color() }}">
                                {{ $kunjungan->status->label() }}
                            </span>
                            <span class="text-sm text-gray-600">{{ $kunjungan->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-900 mb-1">
                            <strong>Tanggal:</strong> {{ $kunjungan->tanggal_utama->format('d F Y') }}
                        </p>
                        @if($kunjungan->tanggal_disetujui)
                        <p class="text-sm text-green-600">
                            <strong>Disetujui:</strong> {{ $kunjungan->tanggal_disetujui->format('d F Y') }}
                        </p>
                        @endif
                        @if($kunjungan->petugas->count() > 0)
                        <p class="text-sm text-gray-600 mt-2">
                            <strong>Petugas:</strong> {{ $kunjungan->petugas->pluck('nama')->join(', ') }}
                        </p>
                        @endif
                    </div>
                    <a href="{{ route('pengunjung.kunjungan.show', $kunjungan) }}" class="ml-4 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 text-sm font-medium">
                        Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="mt-2 text-gray-500">Belum ada kunjungan</p>
                <a href="{{ route('pengunjung.kunjungan.create') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Ajukan Kunjungan Pertama
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const occupiedDates = @json($occupiedDates ?? []);
    
    // Simple calendar implementation
    const calendarContainer = document.getElementById('calendar-container');
    const today = new Date();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();
    
    function renderCalendar(month, year) {
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        let calendarHTML = '<div class="mb-4 flex justify-between items-center">';
        calendarHTML += '<button onclick="changeMonth(-1)" class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">‹</button>';
        calendarHTML += `<h3 class="font-semibold">${new Date(year, month).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}</h3>`;
        calendarHTML += '<button onclick="changeMonth(1)" class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">›</button>';
        calendarHTML += '</div>';
        
        calendarHTML += '<div class="grid grid-cols-7 gap-1 text-center text-xs mb-2">';
        const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        dayNames.forEach(day => {
            calendarHTML += `<div class="font-semibold text-gray-600 py-1">${day}</div>`;
        });
        calendarHTML += '</div>';
        
        calendarHTML += '<div class="grid grid-cols-7 gap-1">';
        
        // Empty cells for days before month starts
        for (let i = 0; i < firstDay; i++) {
            calendarHTML += '<div class="aspect-square"></div>';
        }
        
        // Days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const isOccupied = occupiedDates.includes(dateStr);
            const isPast = new Date(year, month, day) < new Date(today.getFullYear(), today.getMonth(), today.getDate());
            const isToday = year === today.getFullYear() && month === today.getMonth() && day === today.getDate();
            
            let cellClass = 'aspect-square flex items-center justify-center rounded text-sm ';
            if (isOccupied) {
                cellClass += 'bg-red-500 text-white font-semibold';
            } else if (isPast) {
                cellClass += 'bg-gray-100 text-gray-400';
            } else if (isToday) {
                cellClass += 'bg-indigo-100 text-indigo-700 font-semibold border-2 border-indigo-500';
            } else {
                cellClass += 'bg-gray-50 text-gray-700 hover:bg-gray-100';
            }
            
            calendarHTML += `<div class="${cellClass}">${day}</div>`;
        }
        
        calendarHTML += '</div>';
        calendarContainer.innerHTML = calendarHTML;
    }
    
    let currentMonthIndex = currentMonth;
    let currentYearIndex = currentYear;
    
    window.changeMonth = function(direction) {
        currentMonthIndex += direction;
        if (currentMonthIndex < 0) {
            currentMonthIndex = 11;
            currentYearIndex--;
        } else if (currentMonthIndex > 11) {
            currentMonthIndex = 0;
            currentYearIndex++;
        }
        renderCalendar(currentMonthIndex, currentYearIndex);
    };
    
    renderCalendar(currentMonthIndex, currentYearIndex);
});
</script>
@endsection