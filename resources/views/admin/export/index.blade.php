@extends('layouts.app')

@section('title', 'Export Laporan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Export Laporan Kunjungan</h1>
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form id="exportForm" class="space-y-6">
            @csrf

            <!-- Period Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Periode Laporan <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2">
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="period_type" value="month" checked class="h-4 w-4 text-indigo-600">
                        <div class="ml-3">
                            <p class="font-medium">Per Bulan</p>
                            <p class="text-sm text-gray-600">Laporan kunjungan dalam satu bulan tertentu</p>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="period_type" value="year" class="h-4 w-4 text-indigo-600">
                        <div class="ml-3">
                            <p class="font-medium">Per Tahun</p>
                            <p class="text-sm text-gray-600">Laporan kunjungan dalam satu tahun penuh</p>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" name="period_type" value="custom" class="h-4 w-4 text-indigo-600">
                        <div class="ml-3">
                            <p class="font-medium">Rentang Tanggal Kustom</p>
                            <p class="text-sm text-gray-600">Pilih tanggal awal dan akhir sendiri</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Month Selection -->
            <div id="monthSelection" class="grid grid-cols-2 gap-4">
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 mb-2">
                        Bulan <span class="text-red-500">*</span>
                    </label>
                    <select id="month" name="month" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <select id="year" name="year" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @for($i = now()->year; $i >= now()->year - 5; $i--)
                            <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Custom Date Range -->
            <div id="customDateRange" class="grid grid-cols-2 gap-4 hidden">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="start_date" name="start_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Akhir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="end_date" name="end_date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Export Format -->
            <div class="border-t pt-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Format Export
                </label>
                    
                    <button type="button" onclick="exportFile('pdf')" class="flex-1 px-6 py-4 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Export ke PDF
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <svg class="h-5 w-5 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-medium mb-1">Informasi:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>File PDF (.pdf) cocok untuk dokumentasi dan cetak</li>
                    <li>Laporan berisi semua data kunjungan pada periode yang dipilih</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodRadios = document.querySelectorAll('input[name="period_type"]');
    const monthSelection = document.getElementById('monthSelection');
    const customDateRange = document.getElementById('customDateRange');
    const monthInput = document.getElementById('month');
    const yearSelect = document.getElementById('year');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    periodRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'month') {
                monthSelection.classList.remove('hidden');
                customDateRange.classList.add('hidden');
                monthInput.required = true;
                yearSelect.required = true;
                startDateInput.required = false;
                endDateInput.required = false;
            } else if (this.value === 'year') {
                monthSelection.classList.add('hidden');
                customDateRange.classList.add('hidden');
                monthInput.required = false;
                yearSelect.required = true;
                startDateInput.required = false;
                endDateInput.required = false;
            } else {
                monthSelection.classList.add('hidden');
                customDateRange.classList.remove('hidden');
                monthInput.required = false;
                yearSelect.required = true;
                startDateInput.required = true;
                endDateInput.required = true;
            }
        });
    });
});

function exportFile(format) {
    const form = document.getElementById('exportForm');
    const periodType = document.querySelector('input[name="period_type"]:checked').value;
    const year = document.getElementById('year').value;
    
    // Validate
    if (!year) {
        alert('Pilih tahun terlebih dahulu');
        return;
    }
    
    // Build params based on period type
    const params = new URLSearchParams();
    params.append('period_type', periodType);
    params.append('year', year);
    
    if (periodType === 'month') {
        const month = document.getElementById('month').value;
        if (!month) {
            alert('Pilih bulan terlebih dahulu');
            return;
        }
        params.append('month', month);
    } else if (periodType === 'custom') {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        
        if (!startDate || !endDate) {
            alert('Pilih tanggal mulai dan akhir terlebih dahulu');
            return;
        }
        
        params.append('start_date', startDate);
        params.append('end_date', endDate);
    }
    
    // Create URL
    const url = format === 'excel' 
        ? '{{ route("admin.export.excel") }}?' + params.toString()
        : '{{ route("admin.export.pdf") }}?' + params.toString();
    
    // Download
    window.location.href = url;
}
</script>
@endsection