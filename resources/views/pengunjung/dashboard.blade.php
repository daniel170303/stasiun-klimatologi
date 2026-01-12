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
@endsection