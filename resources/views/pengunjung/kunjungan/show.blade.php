@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Kunjungan</h1>
        <a href="{{ route('pengunjung.kunjungan.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            Kembali
        </a>
    </div>

    @if($kunjungan->status->value === 'menunggu_konfirmasi')
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong>Perlu Konfirmasi:</strong> Tanggal kunjungan Anda telah disetujui. Silakan konfirmasi ketersediaan Anda.
                </p>
                <a href="{{ route('pengunjung.kunjungan.konfirmasi', $kunjungan) }}" class="mt-2 inline-block px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 text-sm font-medium">
                    Konfirmasi Sekarang
                </a>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Kunjungan</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Utama</p>
                        <p class="font-medium text-lg">{{ $kunjungan->tanggal_utama->format('d F Y') }}</p>
                    </div>
                    
                    @if($kunjungan->tanggal_alternatif)
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Alternatif</p>
                        <p class="font-medium">{{ $kunjungan->tanggal_alternatif->format('d F Y') }}</p>
                    </div>
                    @endif
                    
                    @if($kunjungan->tanggal_disetujui)
                    <div class="p-4 bg-green-50 rounded-md border border-green-200">
                        <p class="text-sm text-gray-600">Tanggal yang Disetujui Admin</p>
                        <p class="font-medium text-lg text-green-700">{{ $kunjungan->tanggal_disetujui->format('d F Y') }}</p>
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
                        <p class="text-sm text-gray-600 mb-2">Surat Permohonan</p>
                        <a href="{{ Storage::url($kunjungan->surat_permohonan) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Unduh Surat
                        </a>
                    </div>
                    @endif
                    
                    @if($kunjungan->keterangan_admin)
                    <div class="p-4 bg-yellow-50 rounded-md border border-yellow-200">
                        <p class="text-sm text-gray-600 mb-1 font-medium">Keterangan Admin</p>
                        <p class="text-gray-800">{{ $kunjungan->keterangan_admin }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Pengajuan</p>
                        <p class="font-medium">{{ $kunjungan->created_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($kunjungan->petugas->count() > 0)
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Petugas yang Ditugaskan</h2>
                <div class="space-y-3">
                    @foreach($kunjungan->petugas as $petugas)
                    <div class="flex items-center p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-100">
                        <div class="flex-shrink-0 h-12 w-12 bg-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-lg">{{ substr($petugas->nama, 0, 1) }}</span>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="font-medium text-gray-900">{{ $petugas->nama }}</p>
                            <p class="text-sm text-gray-600">{{ $petugas->keahlian }}</p>
                        </div>
                        <div class="text-right text-sm text-gray-500">
                            <p>{{ $petugas->email }}</p>
                            <p>{{ $petugas->no_hp }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Status Kunjungan</h2>
                <div class="text-center">
                    <span class="inline-block px-4 py-2 rounded-full text-sm font-medium {{ $kunjungan->status->color() }}">
                        {{ $kunjungan->status->label() }}
                    </span>
                </div>
            </div>

            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 shadow rounded-lg p-6 border border-indigo-100">
                <h3 class="font-semibold text-gray-900 mb-3">Alur Proses</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full {{ in_array($kunjungan->status->value, ['diajukan', 'diverifikasi', 'menunggu_konfirmasi', 'dikonfirmasi', 'petugas_ditugaskan', 'terlaksana', 'selesai']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Pengajuan</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full {{ in_array($kunjungan->status->value, ['diverifikasi', 'menunggu_konfirmasi', 'dikonfirmasi', 'petugas_ditugaskan', 'terlaksana', 'selesai']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Verifikasi Admin</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full {{ in_array($kunjungan->status->value, ['dikonfirmasi', 'petugas_ditugaskan', 'terlaksana', 'selesai']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Konfirmasi Pengunjung</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full {{ in_array($kunjungan->status->value, ['petugas_ditugaskan', 'terlaksana', 'selesai']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Penugasan Petugas</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 rounded-full {{ in_array($kunjungan->status->value, ['terlaksana', 'selesai']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Pelaksanaan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection