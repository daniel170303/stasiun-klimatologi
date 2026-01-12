<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusKunjungan;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifikasiKunjunganRequest;
use App\Mail\KunjunganStatusChanged;
use App\Models\Kunjungan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::with(['pengunjung.user', 'petugas']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('pengunjung', function ($q) use ($request) {
                $q->where('nama_instansi', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_penanggung_jawab', 'like', '%' . $request->search . '%');
            });
        }

        $kunjungan = $query->latest()->paginate(15);

        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load(['pengunjung.user', 'petugas']);

        return view('admin.kunjungan.show', compact('kunjungan'));
    }

    public function verifikasi(Kunjungan $kunjungan)
    {
        if ($kunjungan->status !== StatusKunjungan::DIAJUKAN) {
            return redirect()->back()->with('error', 'Kunjungan tidak dalam status diajukan.');
        }

        return view('admin.kunjungan.verifikasi', compact('kunjungan'));
    }

    public function prosesVerifikasi(VerifikasiKunjunganRequest $request, Kunjungan $kunjungan)
    {
        if ($kunjungan->status !== StatusKunjungan::DIAJUKAN) {
            return redirect()->back()->with('error', 'Kunjungan tidak dalam status diajukan.');
        }

        $kunjungan->update([
            'status' => StatusKunjungan::DIVERIFIKASI,
            'tanggal_disetujui' => $request->tanggal_disetujui,
            'keterangan_admin' => $request->keterangan_admin,
        ]);

        $kunjungan->update(['status' => StatusKunjungan::MENUNGGU_KONFIRMASI]);

        Mail::to($kunjungan->pengunjung->email)->send(
            new KunjunganStatusChanged(
                $kunjungan,
                'Pengajuan kunjungan Anda telah diverifikasi. Silakan konfirmasi tanggal yang disetujui.'
            )
        );

        return redirect()->route('admin.kunjungan.show', $kunjungan)
            ->with('success', 'Kunjungan berhasil diverifikasi!');
    }

    public function assignPetugas(Kunjungan $kunjungan)
    {
        if ($kunjungan->status !== StatusKunjungan::DIKONFIRMASI) {
            return redirect()->back()->with('error', 'Kunjungan belum dikonfirmasi oleh pengunjung.');
        }

        $pegawaiList = Pegawai::aktif()->get();

        return view('admin.kunjungan.assign-petugas', compact('kunjungan', 'pegawaiList'));
    }

    public function prosesAssignPetugas(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'pegawai_ids' => 'required|array|min:2|max:3',
            'pegawai_ids.*' => 'exists:pegawai,id',
        ], [
            'pegawai_ids.required' => 'Pilih minimal 2 petugas.',
            'pegawai_ids.min' => 'Pilih minimal 2 petugas.',
            'pegawai_ids.max' => 'Pilih maksimal 3 petugas.',
        ]);

        if ($kunjungan->status !== StatusKunjungan::DIKONFIRMASI) {
            return redirect()->back()->with('error', 'Kunjungan belum dikonfirmasi oleh pengunjung.');
        }

        $kunjungan->petugas()->sync($request->pegawai_ids);
        
        $kunjungan->update(['status' => StatusKunjungan::PETUGAS_DITUGASKAN]);

        Mail::to($kunjungan->pengunjung->email)->send(
            new KunjunganStatusChanged(
                $kunjungan,
                'Petugas telah ditugaskan untuk kunjungan Anda.'
            )
        );

        return redirect()->route('admin.kunjungan.show', $kunjungan)
            ->with('success', 'Petugas berhasil ditugaskan!');
    }

    public function updateStatus(Request $request, Kunjungan $kunjungan)
    {
        $request->validate([
            'status' => 'required|in:terlaksana,tidak_terlaksana',
            'keterangan_admin' => 'nullable|string',
        ]);

        $statusBaru = $request->status === 'terlaksana' 
            ? StatusKunjungan::TERLAKSANA 
            : StatusKunjungan::TIDAK_TERLAKSANA;

        $kunjungan->update([
            'status' => $statusBaru,
            'keterangan_admin' => $request->keterangan_admin,
        ]);

        if ($statusBaru === StatusKunjungan::TERLAKSANA) {
            $kunjungan->update(['status' => StatusKunjungan::SELESAI]);
        }

        $message = $statusBaru === StatusKunjungan::TERLAKSANA
            ? 'Kunjungan telah selesai dilaksanakan.'
            : 'Kunjungan tidak dapat dilaksanakan.';

        Mail::to($kunjungan->pengunjung->email)->send(
            new KunjunganStatusChanged($kunjungan, $message)
        );

        return redirect()->route('admin.kunjungan.show', $kunjungan)
            ->with('success', 'Status kunjungan berhasil diperbarui!');
    }
}