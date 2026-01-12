<?php

namespace App\Http\Controllers\Pengunjung;

use App\Enums\StatusKunjungan;
use App\Http\Controllers\Controller;
use App\Http\Requests\KunjunganRequest;
use App\Mail\KunjunganStatusChanged;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $pengunjung = auth()->user()->pengunjung;
        
        $query = Kunjungan::where('pengunjung_id', $pengunjung->id)
            ->with('petugas');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kunjungan = $query->latest()->paginate(10);

        return view('pengunjung.kunjungan.index', compact('kunjungan'));
    }

    public function create()
    {
        return view('pengunjung.kunjungan.create');
    }

    public function store(KunjunganRequest $request)
    {
        $pengunjung = auth()->user()->pengunjung;

        $data = $request->validated();
        $data['pengunjung_id'] = $pengunjung->id;
        $data['status'] = StatusKunjungan::DIAJUKAN;

        if ($request->hasFile('surat_permohonan')) {
            $data['surat_permohonan'] = $request->file('surat_permohonan')
                ->store('surat-permohonan', 'public');
        }

        $kunjungan = Kunjungan::create($data);

        // Send email notification
        try {
            Mail::to($pengunjung->email)->send(
                new KunjunganStatusChanged($kunjungan, 'Pengajuan kunjungan Anda telah diterima dan sedang diproses.')
            );
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Failed to send email: ' . $e->getMessage());
        }

        return redirect()->route('pengunjung.kunjungan.index')
            ->with('success', 'Pengajuan kunjungan berhasil diajukan!');
    }

    public function show(Kunjungan $kunjungan)
    {
        // Check authorization - make sure user owns this kunjungan
        $pengunjung = auth()->user()->pengunjung;
        
        if ($kunjungan->pengunjung_id !== $pengunjung->id) {
            abort(403, 'Anda tidak memiliki akses ke kunjungan ini.');
        }

        $kunjungan->load('petugas', 'pengunjung.user');

        return view('pengunjung.kunjungan.show', compact('kunjungan'));
    }

    public function konfirmasi(Kunjungan $kunjungan)
    {
        // Check authorization
        $pengunjung = auth()->user()->pengunjung;
        
        if ($kunjungan->pengunjung_id !== $pengunjung->id) {
            abort(403, 'Anda tidak memiliki akses ke kunjungan ini.');
        }

        if ($kunjungan->status !== StatusKunjungan::MENUNGGU_KONFIRMASI) {
            return redirect()->back()->with('error', 'Kunjungan tidak dalam status menunggu konfirmasi.');
        }

        return view('pengunjung.kunjungan.konfirmasi', compact('kunjungan'));
    }

    public function prosesKonfirmasi(Request $request, Kunjungan $kunjungan)
    {
        // Check authorization
        $pengunjung = auth()->user()->pengunjung;
        
        if ($kunjungan->pengunjung_id !== $pengunjung->id) {
            abort(403, 'Anda tidak memiliki akses ke kunjungan ini.');
        }

        if ($kunjungan->status !== StatusKunjungan::MENUNGGU_KONFIRMASI) {
            return redirect()->back()->with('error', 'Kunjungan tidak dalam status menunggu konfirmasi.');
        }

        $request->validate([
            'konfirmasi' => 'required|in:setuju,tolak',
        ]);

        if ($request->konfirmasi === 'setuju') {
            $kunjungan->update([
                'status' => StatusKunjungan::DIKONFIRMASI,
            ]);

            $message = 'Terima kasih telah mengkonfirmasi jadwal kunjungan. Kami akan segera menugaskan petugas.';
        } else {
            $kunjungan->update([
                'status' => StatusKunjungan::TIDAK_TERLAKSANA,
            ]);

            $message = 'Jadwal kunjungan telah dibatalkan.';
        }

        // Send email notification
        try {
            Mail::to($kunjungan->pengunjung->email)->send(
                new KunjunganStatusChanged($kunjungan, $message)
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send email: ' . $e->getMessage());
        }

        return redirect()->route('pengunjung.kunjungan.show', $kunjungan)
            ->with('success', 'Konfirmasi berhasil disimpan!');
    }
}