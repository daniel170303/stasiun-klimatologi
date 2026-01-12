@php
    $firstDay = $startDate->copy()->startOfMonth();
    $lastDay = $startDate->copy()->endOfMonth();
    $startOfCalendar = $firstDay->copy()->startOfWeek();
    $endOfCalendar = $lastDay->copy()->endOfWeek();
    $today = now()->format('Y-m-d');
@endphp

<div class="overflow-x-auto">
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-sm font-semibold">Minggu</th>
                <th class="border p-2 text-sm font-semibold">Senin</th>
                <th class="border p-2 text-sm font-semibold">Selasa</th>
                <th class="border p-2 text-sm font-semibold">Rabu</th>
                <th class="border p-2 text-sm font-semibold">Kamis</th>
                <th class="border p-2 text-sm font-semibold">Jumat</th>
                <th class="border p-2 text-sm font-semibold">Sabtu</th>
            </tr>
        </thead>
        <tbody>
            @for($week = $startOfCalendar; $week <= $endOfCalendar; $week->addWeek())
                <tr>
                    @for($day = 0; $day < 7; $day++)
                        @php
                            $currentDay = $week->copy()->addDays($day);
                            $dateKey = $currentDay->format('Y-m-d');
                            $isCurrentMonth = $currentDay->month === $currentDate->month;
                            $isToday = $dateKey === $today;
                            $dayKunjungan = $kunjungan->get($dateKey, collect());
                        @endphp
                        <td class="border p-2 align-top h-32 {{ !$isCurrentMonth ? 'bg-gray-50' : '' }} {{ $isToday ? 'bg-blue-50' : '' }}">
                            <div class="font-semibold text-sm mb-1 {{ !$isCurrentMonth ? 'text-gray-400' : '' }} {{ $isToday ? 'text-blue-600' : '' }}">
                                {{ $currentDay->day }}
                            </div>
                            @foreach($dayKunjungan as $item)
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
                                   class="block text-xs p-1 mb-1 rounded border {{ $bgColor }} hover:opacity-80 transition">
                                    <div class="font-medium truncate">{{ $item->pengunjung->nama_instansi }}</div>
                                    <div class="text-xs">{{ $item->jumlah_peserta }} orang</div>
                                </a>
                            @endforeach
                        </td>
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
</div>