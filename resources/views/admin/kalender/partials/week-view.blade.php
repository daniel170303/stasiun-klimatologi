@php
    $today = now()->format('Y-m-d');
    $days = [];
    for($i = 0; $i < 7; $i++) {
        $days[] = $startDate->copy()->addDays($i);
    }
@endphp

<div class="overflow-x-auto">
    <div class="grid grid-cols-7 gap-2 min-w-full">
        @foreach($days as $day)
            @php
                $dateKey = $day->format('Y-m-d');
                $isToday = $dateKey === $today;
                $dayKunjungan = $kunjungan->get($dateKey, collect());
            @endphp
            <div class="border rounded-lg {{ $isToday ? 'bg-blue-50 border-blue-300' : 'bg-white' }}">
                <div class="p-3 border-b {{ $isToday ? 'bg-blue-100 border-blue-300' : 'bg-gray-50' }}">
                    <div class="text-xs text-gray-600">{{ $day->format('l') }}</div>
                    <div class="text-lg font-bold {{ $isToday ? 'text-blue-600' : '' }}">
                        {{ $day->day }}
                    </div>
                </div>
                <div class="p-2 space-y-2">
                    @forelse($dayKunjungan as $item)
                        @php
                            $bgColor = match($item->status->value) {
                                'diajukan' => 'bg-blue-100 border-blue-300 text-blue-800',
                                'diverifikasi' => 'bg-indigo-100 border-indigo-300 text-indigo-800',
                                'menunggu_konfirmasi' => 'bg-yellow-100 border-yellow-300 text-yellow-800',
                                'dikonfirmasi' => 'bg-purple-100 border-purple-300 text-purple-800',
                                'petugas_ditugaskan' => 'bg-pink-100 border-pink-300 text-pink-800',
                                'terlaksana' => 'bg-green-100 border-green-300 text-green-800',
                                'tidak_terlaksana' => 'bg-red-100 border-red-300 text-red-800',
                                'selesai' => 'bg-gray-100 border-gray-300 text-gray-800',
                                default => 'bg-gray-100 border-gray-300 text-gray-800',
                            };
                        @endphp
                        <a href="{{ route('admin.kunjungan.show', $item->id) }}" 
                           class="block p-2 rounded border {{ $bgColor }} hover:opacity-80 transition">
                            <div class="font-medium text-sm truncate">{{ $item->pengunjung->nama_instansi }}</div>
                            <div class="text-xs mt-1">{{ $item->jumlah_peserta }} orang</div>
                            <div class="text-xs mt-1">
                                @if($item->petugas->count() > 0)
                                    <span class="inline-flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        {{ $item->petugas->count() }} petugas
                                    </span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-8 text-gray-400 text-sm">
                            Tidak ada kunjungan
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>