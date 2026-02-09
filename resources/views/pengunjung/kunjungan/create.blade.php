@extends('layouts.app')

@section('title', 'Ajukan Kunjungan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <style>
        /* Style for occupied dates */
        .date-occupied {
            background-color: #fee2e2 !important;
            color: #991b1b !important;
            cursor: not-allowed !important;
        }
        
        /* Style for weekend dates */
        .date-weekend {
            background-color: #fef2f2 !important;
            color: #b91c1c !important;
            cursor: not-allowed !important;
        }
        
        /* Calendar picker styling */
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
        }
    </style>

    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Ajukan Kunjungan Baru</h1>
        <a href="{{ route('pengunjung.kunjungan.index') }}" 
           class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" 
              action="{{ route('pengunjung.kunjungan.store') }}" 
              enctype="multipart/form-data" 
              class="space-y-6">
            @csrf

            <!-- Tanggal Kunjungan Utama -->
            <div>
                <label for="tanggal_utama" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Kunjungan Utama <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       id="tanggal_utama" 
                       name="tanggal_utama" 
                       value="{{ old('tanggal_utama') }}"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('tanggal_utama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Hanya dapat memilih hari Senin sampai Kamis</p>
            </div>

            <!-- Tanggal Alternatif -->
            <div>
                <label for="tanggal_alternatif" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Alternatif (Opsional)
                </label>
                <input type="date" 
                       id="tanggal_alternatif" 
                       name="tanggal_alternatif" 
                       value="{{ old('tanggal_alternatif') }}"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('tanggal_alternatif')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Jika tanggal utama tidak tersedia (hanya Senin-Kamis)</p>
            </div>

            <!-- Jumlah Peserta -->
            <div>
                <label for="jumlah_peserta" class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Peserta <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="jumlah_peserta" 
                       name="jumlah_peserta" 
                       value="{{ old('jumlah_peserta') }}"
                       min="1"
                       max="100"
                       required
                       placeholder="Masukkan jumlah peserta"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('jumlah_peserta')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tujuan Kunjungan -->
            <div>
                <label for="tujuan_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                    Tujuan Kunjungan <span class="text-red-500">*</span>
                </label>
                <textarea id="tujuan_kunjungan" 
                          name="tujuan_kunjungan" 
                          rows="4" 
                          required
                          placeholder="Jelaskan tujuan kunjungan Anda..."
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('tujuan_kunjungan') }}</textarea>
                @error('tujuan_kunjungan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Surat Permohonan -->
            <div>
                <label for="surat_permohonan" class="block text-sm font-medium text-gray-700 mb-2">
                    Surat Permohonan (PDF) <span class="text-red-500">*</span>
                </label>
                <input type="file" 
                       id="surat_permohonan" 
                       name="surat_permohonan" 
                       accept=".pdf"
                       required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('surat_permohonan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Format: PDF, Maksimal 2MB</p>
            </div>

            <!-- Information Box -->
            <div class="bg-blue-50 p-4 rounded-md border border-blue-200">
                <h3 class="text-sm font-medium text-blue-800 mb-2">Informasi Penting:</h3>
                <ul class="list-disc list-inside text-sm text-blue-700 space-y-1">
                    <li>Pastikan tanggal kunjungan minimal H+1 dari hari ini</li>
                    <li>Kunjungan hanya dapat dilakukan pada hari Senin sampai Kamis</li>
                    <li>Surat permohonan harus menggunakan kop instansi resmi</li>
                    <li>Admin akan memverifikasi dan memberitahu ketersediaan tanggal</li>
                    <li>Anda akan menerima notifikasi email setelah pengajuan diproses</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4">
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium transition">
                    Ajukan Kunjungan
                </button>
                <a href="{{ route('pengunjung.kunjungan.index') }}" 
                   class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Date Validation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalUtama = document.getElementById('tanggal_utama');
    const tanggalAlternatif = document.getElementById('tanggal_alternatif');
    
    // Get occupied dates from server
    const occupiedDates = @json($occupiedDates ?? []);
    
    // Store previous values to detect actual changes
    let previousUtama = tanggalUtama ? tanggalUtama.value : '';
    let previousAlternatif = tanggalAlternatif ? tanggalAlternatif.value : '';
    
    /**
     * Check if date is valid day (Monday-Thursday only)
     * @param {string} dateString - Date in YYYY-MM-DD format
     * @return {boolean}
     */
    function isValidDay(dateString) {
        if (!dateString) return false;
        const date = new Date(dateString + 'T00:00:00');
        const day = date.getDay();
        // 1 = Monday, 2 = Tuesday, 3 = Wednesday, 4 = Thursday
        return day >= 1 && day <= 4;
    }
    
    /**
     * Check if date is weekend (Saturday or Sunday) - for backward compatibility
     * @param {string} dateString - Date in YYYY-MM-DD format
     * @return {boolean}
     */
    function isWeekend(dateString) {
        if (!dateString) return false;
        const date = new Date(dateString + 'T00:00:00');
        const day = date.getDay();
        return day === 0 || day === 6; // 0 = Sunday, 6 = Saturday
    }
    
    /**
     * Check if date is already occupied
     * @param {string} dateString - Date in YYYY-MM-DD format
     * @return {boolean}
     */
    function isOccupied(dateString) {
        if (!dateString) return false;
        return occupiedDates.includes(dateString);
    }
    
    /**
     * Get day name in Indonesian
     * @param {string} dateString - Date in YYYY-MM-DD format
     * @return {string}
     */
    function getDayName(dateString) {
        const date = new Date(dateString + 'T00:00:00');
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        return days[date.getDay()];
    }
    
    /**
     * Format date to Indonesian format
     * @param {string} dateString - Date in YYYY-MM-DD format
     * @return {string}
     */
    function formatDate(dateString) {
        const date = new Date(dateString + 'T00:00:00');
        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    }
    
    /**
     * Validate date selection
     * @param {HTMLInputElement} input - The date input element
     * @param {string} previousValue - Previous value to compare
     * @return {string} - Current value after validation
     */
    function validateDate(input, previousValue) {
        const selectedDate = input.value;
        
        // If value hasn't changed or is empty, don't validate
        if (!selectedDate || selectedDate === previousValue) {
            return selectedDate;
        }
        
        // Check if valid day (Monday-Thursday only)
        if (!isValidDay(selectedDate)) {
            const dayName = getDayName(selectedDate);
            const formattedDate = formatDate(selectedDate);
            alert(`Tidak dapat memilih hari ${dayName}, ${formattedDate}.\n\nKunjungan hanya dapat dilakukan pada hari Senin sampai Kamis.`);
            input.value = previousValue;
            return previousValue;
        }
        
        // Check if occupied
        if (isOccupied(selectedDate)) {
            const formattedDate = formatDate(selectedDate);
            alert(`Tanggal ${formattedDate} sudah ada kunjungan yang diverifikasi.\n\nSilakan pilih tanggal lain.`);
            input.value = previousValue;
            return previousValue;
        }
        
        return selectedDate;
    }
    
    // Add event listeners for tanggal utama
    if (tanggalUtama) {
        // Only validate on blur (when user finishes selecting)
        tanggalUtama.addEventListener('blur', function() {
            previousUtama = validateDate(this, previousUtama);
        });
        
        // Also validate on change (when calendar closes)
        tanggalUtama.addEventListener('change', function() {
            previousUtama = validateDate(this, previousUtama);
        });
    }
    
    // Add event listeners for tanggal alternatif
    if (tanggalAlternatif) {
        // Only validate on blur (when user finishes selecting)
        tanggalAlternatif.addEventListener('blur', function() {
            previousAlternatif = validateDate(this, previousAlternatif);
        });
        
        // Also validate on change (when calendar closes)
        tanggalAlternatif.addEventListener('change', function() {
            previousAlternatif = validateDate(this, previousAlternatif);
        });
    }
    
    // Display occupied dates info in console (for debugging)
    if (occupiedDates.length > 0) {
        console.log('Tanggal yang sudah terisi:', occupiedDates);
    }
});
</script>
@endsection