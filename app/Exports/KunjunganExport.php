<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use PDF; // atau use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function pdf(Request $request)
    {
        // Validasi
        $request->validate([
            'period_type' => 'required|in:month,year,custom',
            'year' => 'required|integer',
            'month' => 'required_if:period_type,month|nullable|integer|between:1,12',
            'start_date' => 'required_if:period_type,custom|nullable|date',
            'end_date' => 'required_if:period_type,custom|nullable|date|after_or_equal:start_date',
        ]);

        // Tentukan date range
        $dateRange = $this->getDateRange($request);
        
        // Ambil data
        $kunjungan = Kunjungan::with(['pengunjung', 'petugas'])
            ->whereBetween('created_at', $dateRange)
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik
        $statistik = [
            'total' => $kunjungan->count(),
            'diajukan' => $kunjungan->where('status', 'diajukan')->count(),
            'terlaksana' => $kunjungan->where('status', 'terlaksana')->count(),
            'tidak_terlaksana' => $kunjungan->where('status', 'tidak_terlaksana')->count(),
            'total_peserta' => $kunjungan->sum('jumlah_peserta'),
        ];

        // Format periode untuk judul
        $period = $this->formatPeriod($request);

        // Data untuk view
        $data = [
            'kunjungan' => $kunjungan,
            'statistik' => $statistik,
            'period' => $period,
        ];

        // KONVERSI LOGO KE BASE64 LANGSUNG DI CONTROLLER
        $logoPath = public_path('images/Logo_BMKG.png');
        if (file_exists($logoPath)) {
            $imageData = base64_encode(file_get_contents($logoPath));
            $data['logoBase64'] = 'data:image/png;base64,' . $imageData;
        } else {
            $data['logoBase64'] = null;
        }

        // Generate PDF dengan konfigurasi khusus
        $pdf = PDF::loadView('admin.export.pdf', $data);
        
        // KONFIGURASI PENTING UNTUK BYPASS GD
        $pdf->setPaper('A4', 'landscape');
        
        // Set options untuk DomPDF
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false, // Karena pakai base64, tidak perlu remote
            'isFontSubsettingEnabled' => true,
            'isPhpEnabled' => false, // Tidak perlu PHP di PDF
            'debugKeepTemp' => false,
        ]);

        // Download
        $filename = 'Laporan_Kunjungan_' . now()->format('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }

    private function getDateRange(Request $request)
    {
        switch ($request->period_type) {
            case 'month':
                $start = Carbon::create($request->year, $request->month, 1)->startOfMonth();
                $end = Carbon::create($request->year, $request->month, 1)->endOfMonth();
                break;
            
            case 'year':
                $start = Carbon::create($request->year, 1, 1)->startOfYear();
                $end = Carbon::create($request->year, 12, 31)->endOfYear();
                break;
            
            case 'custom':
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end = Carbon::parse($request->end_date)->endOfDay();
                break;
            
            default:
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
        }

        return [$start, $end];
    }

    private function formatPeriod(Request $request)
    {
        switch ($request->period_type) {
            case 'month':
                return Carbon::create($request->year, $request->month, 1)->format('F Y');
            
            case 'year':
                return 'Tahun ' . $request->year;
            
            case 'custom':
                $start = Carbon::parse($request->start_date)->format('d M Y');
                $end = Carbon::parse($request->end_date)->format('d M Y');
                return $start . ' - ' . $end;
            
            default:
                return now()->format('F Y');
        }
    }
}