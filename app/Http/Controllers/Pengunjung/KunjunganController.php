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
use Carbon\Carbon;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pengunjung = auth()->user()->pengunjung;
        
        $query = Kunjungan::where('pengunjung_id', $pengunjung->id)
            ->with('petugas');

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kunjungan = $query->latest()->paginate(10);

        return view('pengunjung.kunjungan.index', compact('kunjungan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get all occupied dates (dates with verified visits)
        $occupiedDates = Kunjungan::whereIn('status', [
                StatusKunjungan::MENUNGGU_KONFIRMASI,
                StatusKunjungan::DIKONFIRMASI, 
                StatusKunjungan::PETUGAS_DITUGASKAN,
                StatusKunjungan::TERLAKSANA
            ])
            ->whereNotNull('tanggal_disetujui')
            ->pluck('tanggal_disetujui')
            ->map(function($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->toArray();
        
        return view('pengunjung.kunjungan.create', compact('occupiedDates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param KunjunganRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(KunjunganRequest $request)
    {
        $pengunjung = auth()->user()->pengunjung;

        $data = $request->validated();
        $data['pengunjung_id'] = $pengunjung->id;
        $data['status'] = StatusKunjungan::DIAJUKAN;

        // Handle file upload
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

    /**
     * Display the specified resource.
     *
     * @param Kunjungan $kunjungan
     * @return \Illuminate\View\View
     */
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

    /**
     * Show confirmation form for approved visit.
     *
     * @param Kunjungan $kunjungan
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * Process visitor's confirmation (accept or reject).
     *
     * @param Request $request
     * @param Kunjungan $kunjungan
     * @return \Illuminate\Http\RedirectResponse
     */
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