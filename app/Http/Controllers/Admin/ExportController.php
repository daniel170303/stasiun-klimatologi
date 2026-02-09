<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KunjunganExport;

class ExportController extends Controller
{
    /**
     * Halaman export
     */
    public function index()
    {
        return view('admin.export.index');
    }

    /**
     * Export Excel
     */
    public function exportExcel(Request $request)
    {
        $rules = [
            'period_type' => 'required|in:month,year,custom',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ];

        if ($request->period_type === 'month') {
            $rules['month'] = 'required|integer|min:1|max:12';
        } elseif ($request->period_type === 'custom') {
            $rules['start_date'] = 'required|date';
            $rules['end_date'] = 'required|date|after_or_equal:start_date';
        }

        $request->validate($rules);

        $filename = $this->generateFilename($request, 'xlsx');

        return Excel::download(
            new KunjunganExport($this->getDateRange($request)),
            $filename
        );
    }

    /**
     * Export PDF (dengan Kop Surat BMKG)
     */
    public function exportPdf(Request $request)
    {
        $rules = [
            'period_type' => 'required|in:month,year,custom',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ];

        if ($request->period_type === 'month') {
            $rules['month'] = 'required|integer|min:1|max:12';
        } elseif ($request->period_type === 'custom') {
            $rules['start_date'] = 'required|date';
            $rules['end_date'] = 'required|date|after_or_equal:start_date';
        }

        $request->validate($rules);

        $dateRange = $this->getDateRange($request);

        $kunjungan = Kunjungan::with(['pengunjung', 'petugas'])
            ->whereBetween('created_at', $dateRange)
            ->orderBy('created_at', 'desc')
            ->get();

        $statistik = [
            'total' => $kunjungan->count(),
            'diajukan' => $kunjungan->where('status', 'diajukan')->count(),
            'selesai' => $kunjungan->where('status', 'selesai')->count(),
            'tidak_terlaksana' => $kunjungan->where('status', 'tidak_terlaksana')->count(),
            'total_peserta' => $kunjungan->sum('jumlah_peserta'),
        ];

        // Convert logo to base64 (PNG atau SVG) - tanpa menggunakan GD
        $logoPath = public_path('images/Logo_BMKG.png');
        $logoBase64 = null;
        
        if (file_exists($logoPath)) {
            try {
                $imageData = file_get_contents($logoPath);
                $logoBase64 = 'data:image/png;base64,' . base64_encode($imageData);
            } catch (\Exception $e) {
                $logoBase64 = null;
            }
        } else {
            // Jika PNG tidak ada, coba SVG
            $logoSvgPath = public_path('images/Logo_BMKG.svg');
            if (file_exists($logoSvgPath)) {
                try {
                    $svgContent = file_get_contents($logoSvgPath);
                    $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode($svgContent);
                } catch (\Exception $e) {
                    $logoBase64 = null;
                }
            }
        }

        // Prepare foto kunjungan dengan base64 - tanpa menggunakan GD
        $kunjunganWithFoto = $kunjungan->map(function($item) {
            if ($item->foto_kunjungan) {
                $fotoPath = public_path('storage/' . $item->foto_kunjungan);
                if (file_exists($fotoPath)) {
                    try {
                        $imageData = file_get_contents($fotoPath);
                        $extension = strtolower(pathinfo($fotoPath, PATHINFO_EXTENSION));
                        $mimeTypes = [
                            'jpg' => 'image/jpeg',
                            'jpeg' => 'image/jpeg',
                            'png' => 'image/png',
                            'gif' => 'image/gif',
                            'webp' => 'image/webp'
                        ];
                        $mimeType = $mimeTypes[$extension] ?? 'image/jpeg';
                        $item->foto_base64 = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
                    } catch (\Exception $e) {
                        $item->foto_base64 = null;
                    }
                } else {
                    $item->foto_base64 = null;
                }
            } else {
                $item->foto_base64 = null;
            }
            return $item;
        });

        $pdf = Pdf::loadView('admin.export.pdf', [
                'kunjungan' => $kunjunganWithFoto,
                'statistik' => $statistik,
                'period' => $this->getPeriodLabel($request),
                'logoBase64' => $logoBase64,
            ])
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'isFontSubsettingEnabled' => true,
                'isPhpEnabled' => false,
                'debugKeepTemp' => false,
            ]);

        $filename = $this->generateFilename($request, 'pdf');

        return $pdf->download($filename);
    }

    /**
     * Ambil rentang tanggal
     */
    private function getDateRange(Request $request)
    {
        $periodType = $request->period_type;
        $year = $request->year;

        if ($periodType === 'month') {
            $month = $request->month;
            $start = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();
        } elseif ($periodType === 'year') {
            $start = Carbon::createFromDate($year, 1, 1)->startOfYear();
            $end = $start->copy()->endOfYear();
        } else {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
        }

        return [$start, $end];
    }

    /**
     * Generate nama file
     */
    private function generateFilename(Request $request, $extension)
    {
        $periodType = $request->period_type;
        $year = $request->year;

        if ($periodType === 'month') {
            $month = Carbon::createFromDate($year, $request->month, 1)->format('F');
            return "Laporan_Kunjungan_{$month}_{$year}.{$extension}";
        } elseif ($periodType === 'year') {
            return "Laporan_Kunjungan_{$year}.{$extension}";
        } else {
            $start = Carbon::parse($request->start_date)->format('Y-m-d');
            $end = Carbon::parse($request->end_date)->format('Y-m-d');
            return "Laporan_Kunjungan_{$start}_sd_{$end}.{$extension}";
        }
    }

    /**
     * Label periode (untuk judul laporan)
     */
    private function getPeriodLabel(Request $request)
    {
        $periodType = $request->period_type;
        $year = $request->year;

        if ($periodType === 'month') {
            $month = Carbon::createFromDate($year, $request->month, 1)->format('F');
            return "{$month} {$year}";
        } elseif ($periodType === 'year') {
            return "Tahun {$year}";
        } else {
            $start = Carbon::parse($request->start_date)->format('d F Y');
            $end = Carbon::parse($request->end_date)->format('d F Y');
            return "{$start} - {$end}";
        }
    }
}