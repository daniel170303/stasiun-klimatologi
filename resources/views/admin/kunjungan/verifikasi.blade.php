@extends('layouts.app')

@section('title', 'Verifikasi Kunjungan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <style>
        .date-occupied {
            background-color: #fee2e2 !important;
            color: #991b1b !important;
        }
    </style>
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Verifikasi Kunjungan</h1>
        <a href="{{ route('admin.kunjungan.show', $kunjungan) }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kunjungan</h2>
        <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-md">
            <div>
                <p class="text-sm text-gray-600">Instansi</p>
                <p class="font-medium">{{ $kunjungan->pengunjung->nama_instansi }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Penanggung Jawab</p>
                <p class="font-medium">{{ $kunjungan->pengunjung->nama_penanggung_jawab }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Tanggal Utama</p>
                <p class="font-medium">{{ $kunjungan->tanggal_utama->format('d F Y') }}</p>
            </div>
            @if($kunjungan->tanggal_alternatif)
            <div>
                <p class="text-sm text-gray-600">Tanggal Alternatif</p>
                <p class="font-medium">{{ $kunjungan->tanggal_alternatif->format('d F Y') }}</p>
            </div>
            @endif
            <div>
                <p class="text-sm text-gray-600">Jumlah Peserta</p>
                <p class="font-medium">{{ $kunjungan->jumlah_peserta }} orang</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Tujuan Kunjungan</p>
                <p class="font-medium">{{ $kunjungan->tujuan_kunjungan }}</p>
            </div>
            @if($kunjungan->surat_permohonan)
            <div class="col-span-2">
                <p class="text-sm text-gray-600 mb-2">Surat Permohonan</p>
                <a href="{{ Storage::url($kunjungan->surat_permohonan) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Lihat Surat Permohonan
                </a>
            </div>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.kunjungan.proses-verifikasi', $kunjungan) }}" class="space-y-6">
            @csrf

            <div>
                <label for="tanggal_disetujui" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal yang Disetujui <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       id="tanggal_disetujui" 
                       name="tanggal_disetujui" 
                       value="{{ old('tanggal_disetujui', $kunjungan->tanggal_utama->format('Y-m-d')) }}"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('tanggal_disetujui')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    Pilih tanggal dari tanggal yang diajukan: {{ $kunjungan->tanggal_utama->format('d F Y') }}
                    @if($kunjungan->tanggal_alternatif)
                    atau {{ $kunjungan->tanggal_alternatif->format('d F Y') }}
                    @endif
                </p>
            </div>

            <div>
                <label for="keterangan_admin" class="block text-sm font-medium text-gray-700 mb-2">
                    Keterangan (Opsional)
                </label>
                <textarea id="keterangan_admin" 
                          name="keterangan_admin" 
                          rows="4" 
                          placeholder="Masukkan keterangan jika diperlukan..."
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('keterangan_admin') }}</textarea>
                @error('keterangan_admin')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium mb-1">Perhatian:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Setelah verifikasi, status akan berubah menjadi "Menunggu Konfirmasi"</li>
                            <li>Pengunjung akan menerima notifikasi email untuk konfirmasi tanggal</li>
                            <li>Pastikan tanggal yang dipilih sesuai ketersediaan</li>
                            <li><strong>Sistem akan mencegah pemilihan tanggal yang sudah terisi</strong></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Peringatan Tanggal Terisi -->
            <div id="date-warning" class="bg-red-50 border border-red-200 rounded-md p-4 hidden">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="text-sm text-red-700">
                        <p class="font-medium">Tanggal Tidak Tersedia!</p>
                        <p id="warning-message"></p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" id="submit-btn" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium">
                    Verifikasi & Kirim Notifikasi
                </button>
                <a href="{{ route('admin.kunjungan.show', $kunjungan) }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let occupiedDates = [];
    
    // Fetch occupied dates
    fetch('/api/dates/occupied')
        .then(response => response.json())
        .then(data => {
            occupiedDates = data.occupied_dates;
            console.log('Occupied dates:', occupiedDates);
        })
        .catch(error => console.error('Error fetching occupied dates:', error));
    
    const dateInput = document.getElementById('tanggal_disetujui');
    const warningBox = document.getElementById('date-warning');
    const warningMessage = document.getElementById('warning-message');
    const submitBtn = document.getElementById('submit-btn');
    
    dateInput.addEventListener('change', function() {
        const selectedDate = this.value;
        
        if (occupiedDates.includes(selectedDate)) {
            // Show warning
            const dateObj = new Date(selectedDate + 'T00:00:00');
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = dateObj.toLocaleDateString('id-ID', options);
            
            warningMessage.textContent = `Tanggal ${formattedDate} sudah ada kunjungan yang dijadwalkan. Silakan pilih tanggal lain.`;
            warningBox.classList.remove('hidden');
            
            this.style.borderColor = '#dc2626';
            this.style.backgroundColor = '#fee2e2';
            
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            // Hide warning
            warningBox.classList.add('hidden');
            this.style.borderColor = '';
            this.style.backgroundColor = '';
            
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    });
    
    // Prevent form submission if date is occupied
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const selectedDate = dateInput.value;
        
        if (occupiedDates.includes(selectedDate)) {
            e.preventDefault();
            alert('Tanggal yang Anda pilih sudah ada kunjungan. Silakan pilih tanggal lain.');
            return false;
        }
    });
});
</script>
@endsection