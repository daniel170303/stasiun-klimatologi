@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Pegawai</h1>
            <p class="text-gray-600 mt-1">History penugasan kunjungan</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pegawai.edit', $pegawai) }}" 
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Edit Data
            </a>
            <a href="{{ route('admin.pegawai.index') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </div>

    <!-- Info Pegawai -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pegawai</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama</dt>
                        <dd class="text-base text-gray-900">{{ $pegawai->nama }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-base text-gray-900">{{ $pegawai->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">No. HP</dt>
                        <dd class="text-base text-gray-900">{{ $pegawai->no_hp }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Keahlian</dt>
                        <dd class="text-base text-gray-900">{{ $pegawai->keahlian ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd>
                            <span class="px-2 py-1 text-xs rounded-full {{ $pegawai->status_aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $pegawai->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Penugasan</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600">{{ $totalPenugasan }}</div>
                        <div class="text-sm text-gray-600">Total Penugasan</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600">{{ $penugasanTerlaksana }}</div>
                        <div class="text-sm text-gray-600">Terlaksana</div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-yellow-600">{{ $penugasanMenunggu }}</div>
                        <div class="text-sm text-gray-600">Menunggu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History Penugasan -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">History Penugasan Kunjungan</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Instansi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kunjungan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tujuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pegawai->kunjungans as $index => $kunjungan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="font-medium">{{ $kunjungan->pengunjung->nama_instansi }}</div>
                            <div class="text-gray-500">{{ $kunjungan->pengunjung->nama_penanggung_jawab }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($kunjungan->tanggal_disetujui)
                                {{ $kunjungan->tanggal_disetujui->format('d M Y') }}
                            @else
                                {{ $kunjungan->tanggal_utama->format('d M Y') }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ Str::limit($kunjungan->tujuan_kunjungan ?? '-', 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full {{ $kunjungan->status->color() }}">
                                {{ $kunjungan->status->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.kunjungan.show', $kunjungan) }}" 
                               class="text-indigo-600 hover:text-indigo-900">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p>Belum ada penugasan kunjungan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Timeline Penugasan -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Timeline Penugasan</h2>
        
        @if($pegawai->kunjungans->count() > 0)
        <div class="flow-root">
            <ul class="-mb-8">
                @foreach($pegawai->kunjungans as $index => $kunjungan)
                <li>
                    <div class="relative pb-8">
                        @if(!$loop->last)
                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        @endif
                        <div class="relative flex items-start space-x-3">
                            <div>
                                <div class="relative px-1">
                                    <div class="h-8 w-8 rounded-full {{ $kunjungan->status->value === 'terlaksana' ? 'bg-green-500' : 'bg-gray-400' }} flex items-center justify-center ring-8 ring-white">
                                        @if($kunjungan->status->value === 'terlaksana')
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        @else
                                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="text-sm">
                                        <span class="font-medium text-gray-900">{{ $kunjungan->pengunjung->nama_instansi }}</span>
                                        <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $kunjungan->status->color() }}">
                                            {{ $kunjungan->status->label() }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">
                                        @if($kunjungan->tanggal_disetujui)
                                            {{ $kunjungan->tanggal_disetujui->format('d M Y') }}
                                        @else
                                            {{ $kunjungan->tanggal_utama->format('d M Y') }}
                                        @endif
                                        • {{ $kunjungan->tujuan_kunjungan ?? 'Tidak ada tujuan' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @else
        <p class="text-gray-500 text-sm text-center py-4">Belum ada history penugasan</p>
        @endif
    </div>
</div>
@endsection