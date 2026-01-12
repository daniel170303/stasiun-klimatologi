<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil data pengunjung dari relasi user
        $pengunjung = $user->pengunjung;

        // ⛔ Jika data pengunjung belum ada
        if (!$pengunjung) {
            abort(404, 'Data pengunjung belum tersedia.');
        }

        // Total semua kunjungan
        $totalKunjungan = Kunjungan::where('pengunjung_id', $pengunjung->id)
            ->count();

        // Kunjungan dengan status diajukan
        $kunjunganDiajukan = Kunjungan::where('pengunjung_id', $pengunjung->id)
            ->where('status', 'diajukan')
            ->count();

        // Kunjungan dengan status terlaksana
        $kunjunganTerlaksana = Kunjungan::where('pengunjung_id', $pengunjung->id)
            ->where('status', 'terlaksana')
            ->count();

        // 5 kunjungan terbaru
        $kunjunganTerbaru = Kunjungan::where('pengunjung_id', $pengunjung->id)
            ->with('petugas')
            ->latest()
            ->take(5)
            ->get();

        return view('pengunjung.dashboard', compact(
            'totalKunjungan',
            'kunjunganDiajukan',
            'kunjunganTerlaksana',
            'kunjunganTerbaru'
        ));
    }
}
