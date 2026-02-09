@extends('layouts.app')

@section('title', 'Buat Kunjungan Manual')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Buat Kunjungan Manual</h1>
        <a href="{{ route('admin.kunjungan.index') }}" 
           class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" 
              action="{{ route('admin.kunjungan.store') }}" 
              enctype="multipart/form-data" 
              class="space-y-6">
            @csrf

            <!-- Pilih Pengunjung -->
            <div>
                <label for="pengunjung_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Pengunjung <span class="text-red-500">*</span>
                </label>
                <select id="pengunjung_id" 
                        name="pengunjung_id" 
                        required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Pilih Pengunjung</option>
                    @foreach($pengunjungList as $pengunjung)
                    <option value="{{ $pengunjung->id }}" {{ old('pengunjung_id') == $pengunjung->id ? 'selected' : '' }}>
                        {{ $pengunjung->nama_instansi }} - {{ $pengunjung->nama_penanggung_jawab }}
                    </option>
                    @endforeach
                </select>
                @error('pengunjung_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

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
                          placeholder="Jelaskan tujuan kunjungan..."
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('tujuan_kunjungan') }}</textarea>
                @error('tujuan_kunjungan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Surat Permohonan -->
            <div>
                <label for="surat_permohonan" class="block text-sm font-medium text-gray-700 mb-2">
                    Surat Permohonan (PDF) <span class="text-gray-500">(Opsional)</span>
                </label>
                <input type="file" 
                       id="surat_permohonan" 
                       name="surat_permohonan" 
                       accept=".pdf"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('surat_permohonan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Format: PDF, Maksimal 2MB</p>
            </div>

            <!-- Information Box -->
            <div class="bg-blue-50 p-4 rounded-md border border-blue-200">
                <h3 class="text-sm font-medium text-blue-800 mb-2">Informasi:</h3>
                <ul class="list-disc list-inside text-sm text-blue-700 space-y-1">
                    <li>Kunjungan yang dibuat admin akan langsung berstatus "Dikonfirmasi"</li>
                    <li>Anda dapat langsung menugaskan petugas setelah kunjungan dibuat</li>
                    <li>Pengunjung akan menerima notifikasi email otomatis</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4">
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium transition">
                    Buat Kunjungan
                </button>
                <a href="{{ route('admin.kunjungan.index') }}" 
                   class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

