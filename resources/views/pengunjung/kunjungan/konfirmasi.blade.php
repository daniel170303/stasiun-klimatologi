@extends('layouts.app')

@section('title', 'Konfirmasi Kunjungan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Konfirmasi Kunjungan</h1>
        <a href="{{ route('pengunjung.kunjungan.show', $kunjungan) }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
            <h3 class="text-sm font-medium text-blue-800 mb-2">Informasi</h3>
            <p class="text-sm text-blue-700">
                Admin telah menyetujui tanggal kunjungan Anda. Silakan konfirmasi apakah Anda dapat hadir pada tanggal yang telah disetujui.
            </p>
        </div>

        <div class="mb-6 p-6 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Kunjungan</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Instansi</p>
                    <p class="font-medium">{{ $kunjungan->pengunjung->nama_instansi }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal yang Diajukan</p>
                    <p class="font-medium">{{ $kunjungan->tanggal_utama->format('d F Y') }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Tanggal yang Disetujui Admin</p>
                    <p class="font-bold text-lg text-green-600">{{ $kunjungan->tanggal_disetujui->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Jumlah Peserta</p>
                    <p class="font-medium">{{ $kunjungan->jumlah_peserta }} orang</p>
                </div>
                @if($kunjungan->keterangan_admin)
                <div class="col-span-2 p-3 bg-yellow-50 border border-yellow-200 rounded">
                    <p class="text-sm text-gray-600 font-medium mb-1">Keterangan Admin:</p>
                    <p class="text-sm text-gray-800">{{ $kunjungan->keterangan_admin }}</p>
                </div>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('pengunjung.kunjungan.proses-konfirmasi', $kunjungan) }}" class="space-y-6">
            @csrf

            <div class="p-4 bg-yellow-50 border border-yellow-300 rounded-md">
                <p class="text-sm text-yellow-800 font-medium mb-3">
                    Apakah Anda dapat hadir pada tanggal yang telah disetujui?
                </p>
                
                <div class="space-y-3">
                    <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" 
                               name="konfirmasi" 
                               value="setuju" 
                               required
                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                        <div class="ml-3 flex-1">
                            <p class="font-medium text-gray-900">Ya, saya bersedia hadir</p>
                            <p class="text-sm text-gray-600">Saya dapat hadir pada tanggal yang telah disetujui</p>
                        </div>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <input type="radio" 
                               name="konfirmasi" 
                               value="tolak" 
                               required
                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                        <div class="ml-3 flex-1">
                            <p class="font-medium text-gray-900">Tidak, saya tidak bisa hadir</p>
                            <p class="text-sm text-gray-600">Saya berhalangan hadir pada tanggal tersebut</p>
                        </div>
                    </label>
                </div>
                
                @error('konfirmasi')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-red-50 p-4 rounded-md border border-red-200">
                <p class="text-sm text-red-800">
                    <strong>Perhatian:</strong> Jika Anda memilih "Tidak bisa hadir", kunjungan akan dibatalkan dan Anda perlu mengajukan kunjungan baru dengan tanggal yang berbeda.
                </p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium">
                    Submit Konfirmasi
                </button>
                <a href="{{ route('pengunjung.kunjungan.show', $kunjungan) }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const konfirmasi = document.querySelector('input[name="konfirmasi"]:checked');
        if (!konfirmasi) {
            e.preventDefault();
            alert('Silakan pilih salah satu opsi konfirmasi');
            return;
        }
        
        if (konfirmasi.value === 'tolak') {
            if (!confirm('Anda yakin tidak bisa hadir? Kunjungan akan dibatalkan.')) {
                e.preventDefault();
            }
        } else {
            if (!confirm('Konfirmasi kehadiran Anda pada tanggal yang telah disetujui?')) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection