<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusKunjungan;
use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Pegawai;
use App\Models\Pengunjung;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKunjungan = Kunjungan::count();
        $kunjunganDiajukan = Kunjungan::where('status', StatusKunjungan::DIAJUKAN)->count();
        $kunjunganTerlaksana = Kunjungan::where('status', StatusKunjungan::TERLAKSANA)->count();
        $totalPengunjung = Pengunjung::count();
        $totalPegawai = Pegawai::aktif()->count();
        
        $kunjunganTerbaru = Kunjungan::with(['pengunjung.user', 'petugas'])
            ->latest()
            ->take(5)
            ->get();

        $statistikStatus = Kunjungan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status->label() => $item->total];
            });

        return view('admin.dashboard', compact(
            'totalKunjungan',
            'kunjunganDiajukan',
            'kunjunganTerlaksana',
            'totalPengunjung',
            'totalPegawai',
            'kunjunganTerbaru',
            'statistikStatus'
        ));
    }
}