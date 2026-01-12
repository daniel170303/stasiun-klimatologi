@extends('layouts.app')

@section('title', 'Kunjungan Saya')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Kunjungan Saya</h1>
        <a href="{{ route('pengunjung.kunjungan.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Ajukan Kunjungan
        </a>
    </div>

    <div class="bg-white shadow rounded-lg">
        <div class="p-6">
            <form method="GET" class="mb-6">
                <div class="flex gap-4">
                    <select name="status" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Status</option>
                        @foreach(\App\Enums\StatusKunjungan::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Filter</button>
                    <a href="{{ route('pengunjung.kunjungan.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Reset</a>
                </div>
            </form>

            <div class="space-y-4">
                @forelse($kunjungan as $item)
                <div class="border rounded-lg p-6 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 text-sm rounded-full {{ $item->status->color() }}">
                                    {{ $item->status->label() }}
                                </span>
                                <span class="text-sm text-gray-500">Diajukan {{ $item->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Kunjungan {{ $item->tanggal_utama->format('d F Y') }}</h3>
                        </div>
                        <a href="{{ route('pengunjung.kunjungan.show', $item) }}" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 text-sm font-medium">
                            Lihat Detail
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Tanggal Utama:</span>
                            <span class="font-medium text-gray-900">{{ $item->tanggal_utama->format('d F Y') }}</span>
                        </div>
                        @if($item->tanggal_disetujui)
                        <div>
                            <span class="text-gray-600">Tanggal Disetujui:</span>
                            <span class="font-medium text-green-600">{{ $item->tanggal_disetujui->format('d F Y') }}</span>
                        </div>
                        @endif
                        <div>
                            <span class="text-gray-600">Jumlah Peserta:</span>
                            <span class="font-medium text-gray-900">{{ $item->jumlah_peserta }} orang</span>
                        </div>
                        @if($item->petugas->count() > 0)
                        <div>
                            <span class="text-gray-600">Petugas:</span>
                            <span class="font-medium text-gray-900">{{ $item->petugas->count() }} orang</span>
                        </div>
                        @endif
                    </div>

                    @if($item->status->value === 'menunggu_konfirmasi')
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                        <p class="text-sm text-yellow-800 mb-2">
                            <strong>Perlu Konfirmasi:</strong> Tanggal kunjungan Anda telah disetujui. Silakan konfirmasi ketersediaan Anda.
                        </p>
                        <a href="{{ route('pengunjung.kunjungan.konfirmasi', $item) }}" class="inline-block px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 text-sm font-medium">
                            Konfirmasi Sekarang
                        </a>
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-12">
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

            @if($kunjungan->hasPages())
            <div class="mt-6">
                {{ $kunjungan->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection