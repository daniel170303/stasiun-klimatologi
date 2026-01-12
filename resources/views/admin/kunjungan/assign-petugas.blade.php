@extends('layouts.app')

@section('title', 'Assign Petugas')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Assign Petugas</h1>
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
                <p class="text-sm text-gray-600">Tanggal Kunjungan</p>
                <p class="font-medium">{{ $kunjungan->tanggal_disetujui->format('d F Y') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.kunjungan.proses-assign-petugas', $kunjungan) }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Pilih Petugas (2-3 orang) <span class="text-red-500">*</span>
                </label>
                
                <div class="space-y-3">
                    @forelse($pegawaiList as $pegawai)
                    <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="checkbox" 
                               name="pegawai_ids[]" 
                               value="{{ $pegawai->id }}"
                               {{ in_array($pegawai->id, old('pegawai_ids', [])) ? 'checked' : '' }}
                               class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <div class="ml-3 flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $pegawai->nama }}</p>
                                    <p class="text-sm text-gray-600">{{ $pegawai->keahlian }}</p>
                                </div>
                                <div class="text-right text-sm text-gray-500">
                                    <p>{{ $pegawai->email }}</p>
                                    <p>{{ $pegawai->no_hp }}</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    @empty
                    <p class="text-gray-500">Tidak ada pegawai aktif tersedia</p>
                    @endforelse
                </div>
                
                @error('pegawai_ids')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <p class="mt-2 text-sm text-gray-500">
                    Pilih minimal 2 dan maksimal 3 petugas untuk kunjungan ini
                </p>
            </div>

            @if($pegawaiList->count() >= 2)
            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-6 py-3 bg-purple-600 text-white rounded-md hover:bg-purple-700 font-medium">
                    Tugaskan Petugas
                </button>
                <a href="{{ route('admin.kunjungan.show', $kunjungan) }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium">
                    Batal
                </a>
            </div>
            @else
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                <p class="text-sm text-yellow-800">
                    Minimal 2 pegawai aktif diperlukan untuk menugaskan petugas. Silakan tambah pegawai terlebih dahulu.
                </p>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection