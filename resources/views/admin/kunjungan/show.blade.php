@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Kunjungan</h1>
        <a href="{{ route('admin.kunjungan.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengunjung</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nama Instansi</p>
                        <p class="font-medium">{{ $kunjungan->pengunjung->nama_instansi }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Penanggung Jawab</p>
                        <p class="font-medium">{{ $kunjungan->pengunjung->nama_penanggung_jawab }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium">{{ $kunjungan->pengunjung->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">No. HP</p>
                        <p class="font-medium">{{ $kunjungan->pengunjung->no_hp }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Kunjungan</h2>
                <div class="space-y-4">
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
                    
                    @if($kunjungan->tanggal_disetujui)
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Disetujui</p>
                        <p class="font-medium text-green-600">{{ $kunjungan->tanggal_disetujui->format('d F Y') }}</p>
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
                    <div>
                        <p class="text-sm text-gray-600">Surat Permohonan</p>
                        <a href="{{ Storage::url($kunjungan->surat_permohonan) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Lihat Surat
                        </a>
                    </div>
                    @endif
                    
                    @if($kunjungan->keterangan_admin)
                    <div class="bg-yellow-50 p-4 rounded-md border border-yellow-200">
                        <p class="text-sm text-gray-600 mb-1">Keterangan Admin</p>
                        <p class="font-medium text-gray-800">{{ $kunjungan->keterangan_admin }}</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($kunjungan->petugas->count() > 0)
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Petugas Ditugaskan</h2>
                <div class="space-y-3">
                    @foreach($kunjungan->petugas as $petugas)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                        <div>
                            <p class="font-medium text-gray-900">{{ $petugas->nama }}</p>
                            <p class="text-sm text-gray-600">{{ $petugas->keahlian }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">{{ $petugas->email }}</p>
                            <p class="text-sm text-gray-600">{{ $petugas->no_hp }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Status</h2>
                <div class="text-center">
                    <span class="inline-block px-4 py-2 rounded-full text-sm font-medium {{ $kunjungan->status->color() }}">
                        {{ $kunjungan->status->label() }}
                    </span>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h2>
                <div class="space-y-3">
                    @if($kunjungan->status->value === 'diajukan')
                    <a href="{{ route('admin.kunjungan.verifikasi', $kunjungan) }}" class="block w-full px-4 py-2 bg-green-600 text-white text-center rounded-md hover:bg-green-700">
                        Verifikasi Kunjungan
                    </a>
                    @endif
                    
                    @if($kunjungan->status->value === 'dikonfirmasi')
                    <a href="{{ route('admin.kunjungan.assign-petugas', $kunjungan) }}" class="block w-full px-4 py-2 bg-purple-600 text-white text-center rounded-md hover:bg-purple-700">
                        Assign Petugas
                    </a>
                    @endif
                    
                    @if(in_array($kunjungan->status->value, ['petugas_ditugaskan']))
                    <form method="POST" action="{{ route('admin.kunjungan.update-status', $kunjungan) }}" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label for="foto_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Kunjungan <span class="text-red-500">*</span> <span class="text-xs text-gray-500">(Wajib untuk status Terlaksana)</span>
                            </label>
                            <input type="file" name="foto_kunjungan" id="foto_kunjungan" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maksimal 5MB</p>
                        </div>
                        <textarea name="keterangan_admin" rows="3" placeholder="Keterangan (opsional)" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        <button type="submit" name="status" value="terlaksana" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Tandai Terlaksana
                        </button>
                        <button type="submit" name="status" value="tidak_terlaksana" class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Tandai Tidak Terlaksana
                        </button>
                    </form>
                    @endif
                    
                    @if($kunjungan->foto_kunjungan)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Foto Kunjungan:</p>
                        <img src="{{ Storage::url($kunjungan->foto_kunjungan) }}" alt="Foto Kunjungan" class="w-full rounded-md shadow-md">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection