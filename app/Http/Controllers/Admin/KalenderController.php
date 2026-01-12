<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->get('view', 'month'); // month or week
        $date = $request->get('date', now()->format('Y-m-d'));
        $currentDate = Carbon::parse($date);

        if ($view === 'month') {
            $startDate = $currentDate->copy()->startOfMonth();
            $endDate = $currentDate->copy()->endOfMonth();
        } else {
            $startDate = $currentDate->copy()->startOfWeek();
            $endDate = $currentDate->copy()->endOfWeek();
        }

        $kunjungan = Kunjungan::with(['pengunjung', 'petugas'])
            ->whereBetween('tanggal_disetujui', [$startDate, $endDate])
            ->whereNotNull('tanggal_disetujui')
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_disetujui->format('Y-m-d');
            });

        return view('admin.kalender.index', compact('kunjungan', 'currentDate', 'view', 'startDate', 'endDate'));
    }

    public function getEvents(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $kunjungan = Kunjungan::with(['pengunjung', 'petugas'])
            ->whereBetween('tanggal_disetujui', [$start, $end])
            ->whereNotNull('tanggal_disetujui')
            ->get();

        $events = $kunjungan->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->pengunjung->nama_instansi,
                'start' => $item->tanggal_disetujui->format('Y-m-d'),
                'backgroundColor' => $this->getStatusColor($item->status->value),
                'borderColor' => $this->getStatusColor($item->status->value),
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'status' => $item->status->label(),
                    'peserta' => $item->jumlah_peserta,
                    'petugas' => $item->petugas->pluck('nama')->join(', '),
                ],
            ];
        });

        return response()->json($events);
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'diajukan' => '#3B82F6',           // blue
            'diverifikasi' => '#6366F1',       // indigo
            'menunggu_konfirmasi' => '#EAB308', // yellow
            'dikonfirmasi' => '#8B5CF6',       // purple
            'petugas_ditugaskan' => '#EC4899', // pink
            'terlaksana' => '#10B981',         // green
            'tidak_terlaksana' => '#EF4444',   // red
            'selesai' => '#6B7280',            // gray
            default => '#6B7280',
        };
    }
}