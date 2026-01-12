@extends('layouts.app')

@section('title', 'Ajukan Kunjungan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <style>
        .date-occupied {
            background-color: #fee2e2 !important;
            color: #991b1b !important;
            cursor: not-allowed !important;
        }
    </style>
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Ajukan Kunjungan Baru</h1>
        <a href="{{ route('pengunjung.kunjungan.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('pengunjung.kunjungan.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

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
            </div>

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
                <p class="mt-1 text-sm text-gray-500">Jika tanggal utama tidak tersedia</p>
            </div>

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
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('jumlah_peserta')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

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

            <div class="bg-blue-50 p-4 rounded-md border border-blue-200">
                <h3 class="text-sm font-medium text-blue-800 mb-2">Informasi Penting:</h3>
                <ul class="list-disc list-inside text-sm text-blue-700 space-y-1">
                    <li>Pastikan tanggal kunjungan minimal H+1 dari hari ini</li>
                    <li>Surat permohonan harus menggunakan kop instansi resmi</li>
                    <li>Admin akan memverifikasi dan memberitahu ketersediaan tanggal</li>
                    <li>Anda akan menerima notifikasi email setelah pengajuan diproses</li>
                </ul>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                    Ajukan Kunjungan
                </button>
                <a href="{{ route('pengunjung.kunjungan.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
