<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource with search and filter
     */
    public function index(Request $request)
    {
        $query = Pegawai::query();

        // Search berdasarkan nama, email, no_hp, atau keahlian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('keahlian', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status aktif
        if ($request->filled('status')) {
            $query->where('status_aktif', $request->status);
        }

        // Urutkan berdasarkan nama A-Z
        $query->orderBy('nama', 'asc');

        // Pagination dengan query string preservation
        $pegawai = $query->paginate(15)->withQueryString();

        return view('admin.pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        return view('admin.pegawai.create');
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai,email',
            'no_hp' => 'required|string|max:20',
            'keahlian' => 'nullable|string|max:255',
            'status_aktif' => 'required|boolean',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'status_aktif.required' => 'Status aktif wajib dipilih.',
        ]);

        Pegawai::create($validated);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan!');
    }

    /**
     * Display the specified resource
     */
    public function show(Pegawai $pegawai)
    {
        // Load relasi kunjungans dengan pengunjung
        $pegawai->load(['kunjungans' => function($query) {
            $query->with(['pengunjung'])
                  ->latest('tanggal_utama');
        }]);
        
        // Statistik pegawai
        $totalPenugasan = $pegawai->kunjungans()->count();
        
        $penugasanTerlaksana = $pegawai->kunjungans()
            ->where('status', 'terlaksana')
            ->count();
        
        $penugasanMenunggu = $pegawai->kunjungans()
            ->whereIn('status', [
                'diajukan', 
                'diverifikasi', 
                'menunggu_konfirmasi', 
                'dikonfirmasi', 
                'petugas_ditugaskan'
            ])
            ->count();
        
        $penugasanTidakTerlaksana = $pegawai->kunjungans()
            ->where('status', 'tidak_terlaksana')
            ->count();
        
        return view('admin.pegawai.show', compact(
            'pegawai',
            'totalPenugasan',
            'penugasanTerlaksana',
            'penugasanMenunggu',
            'penugasanTidakTerlaksana'
        ));
    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit(Pegawai $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai,email,' . $pegawai->id,
            'no_hp' => 'required|string|max:20',
            'keahlian' => 'nullable|string|max:255',
            'status_aktif' => 'required|boolean',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'status_aktif.required' => 'Status aktif wajib dipilih.',
        ]);

        $pegawai->update($validated);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(Pegawai $pegawai)
    {
        // Cek apakah pegawai masih memiliki penugasan aktif
        $penugasanAktif = $pegawai->kunjungans()
            ->whereIn('status', [
                'diajukan', 
                'diverifikasi', 
                'menunggu_konfirmasi', 
                'dikonfirmasi', 
                'petugas_ditugaskan'
            ])
            ->count();

        if ($penugasanAktif > 0) {
            return redirect()->route('admin.pegawai.index')
                ->with('error', 'Pegawai tidak dapat dihapus karena masih memiliki ' . $penugasanAktif . ' penugasan aktif.');
        }

        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus!');
    }
}