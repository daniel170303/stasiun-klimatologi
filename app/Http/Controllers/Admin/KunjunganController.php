<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusKunjungan;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifikasiKunjunganRequest;
use App\Mail\KunjunganStatusChanged;
use App\Models\Kunjungan;
use App\Models\Pengunjung;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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

        // Ambil pegawai aktif dengan jumlah kunjungan dan urutkan dari yang paling sedikit
        $pegawaiList = Pegawai::aktif()
            ->withCount(['kunjungans' => function($query) {
                // Hitung hanya kunjungan yang statusnya aktif/relevan
                $query->whereIn('status', [
                    'dikonfirmasi',
                    'petugas_ditugaskan',
                    'terlaksana',
                    'selesai' // ← TAMBAHAN INI
                ]);
            }])
            ->orderBy('kunjungans_count', 'asc') // Urutkan dari yang paling sedikit
            ->orderBy('nama', 'asc') // Jika sama, urutkan berdasarkan nama
            ->get();

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
            'foto_kunjungan' => 'required_if:status,terlaksana|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'foto_kunjungan.required_if' => 'Foto kunjungan wajib diupload sebelum menandai terlaksana.',
            'foto_kunjungan.image' => 'File harus berupa gambar.',
            'foto_kunjungan.mimes' => 'Format file harus jpeg, png, atau jpg.',
            'foto_kunjungan.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $statusBaru = $request->status === 'terlaksana' 
            ? StatusKunjungan::TERLAKSANA 
            : StatusKunjungan::TIDAK_TERLAKSANA;

        $data = [
            'status' => $statusBaru,
            'keterangan_admin' => $request->keterangan_admin,
        ];

        // Handle foto upload jika status terlaksana
        if ($request->status === 'terlaksana' && $request->hasFile('foto_kunjungan')) {
            // Hapus foto lama jika ada
            if ($kunjungan->foto_kunjungan) {
                Storage::disk('public')->delete($kunjungan->foto_kunjungan);
            }
            
            $data['foto_kunjungan'] = $request->file('foto_kunjungan')
                ->store('foto-kunjungan', 'public');
        }

        $kunjungan->update($data);

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

    public function create()
    {
        $pengunjungList = Pengunjung::with('user')->get();
        $occupiedDates = Kunjungan::whereIn('status', [
                StatusKunjungan::MENUNGGU_KONFIRMASI,
                StatusKunjungan::DIKONFIRMASI, 
                StatusKunjungan::PETUGAS_DITUGASKAN,
                StatusKunjungan::TERLAKSANA
            ])
            ->whereNotNull('tanggal_disetujui')
            ->pluck('tanggal_disetujui')
            ->map(function($date) {
                return \Carbon\Carbon::parse($date)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->toArray();

        return view('admin.kunjungan.create', compact('pengunjungList', 'occupiedDates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengunjung_id' => ['required', 'exists:pengunjung,id'],
            'tanggal_utama' => [
                'required', 
                'date', 
                'after:today',
                function ($attribute, $value, $fail) {
                    $dayOfWeek = \Carbon\Carbon::parse($value)->dayOfWeek;
                    // Only allow Monday (1) to Thursday (4)
                    if (!in_array($dayOfWeek, [1, 2, 3, 4])) {
                        $dayName = \Carbon\Carbon::parse($value)->locale('id')->dayName;
                        $fail('Tanggal ' . \Carbon\Carbon::parse($value)->format('d F Y') . ' (' . $dayName . ') tidak dapat dipilih. Kunjungan hanya dapat dilakukan pada hari Senin sampai Kamis.');
                    }
                    
                    if (Kunjungan::where('tanggal_disetujui', $value)
                        ->whereIn('status', [
                            StatusKunjungan::MENUNGGU_KONFIRMASI,
                            StatusKunjungan::DIKONFIRMASI, 
                            StatusKunjungan::PETUGAS_DITUGASKAN,
                            StatusKunjungan::TERLAKSANA
                        ])
                        ->exists()) {
                        $fail('Tanggal ' . \Carbon\Carbon::parse($value)->format('d F Y') . ' sudah ada kunjungan.');
                    }
                },
            ],
            'tanggal_alternatif' => [
                'nullable', 
                'date', 
                'after:today',
            ],
            'jumlah_peserta' => ['required', 'integer', 'min:1', 'max:100'],
            'tujuan_kunjungan' => ['required', 'string', 'max:1000'],
            'surat_permohonan' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ], [
            'pengunjung_id.required' => 'Pengunjung wajib dipilih.',
            'pengunjung_id.exists' => 'Pengunjung tidak ditemukan.',
            'tanggal_utama.required' => 'Tanggal utama wajib diisi.',
            'tanggal_utama.after' => 'Tanggal utama harus setelah hari ini.',
            'jumlah_peserta.required' => 'Jumlah peserta wajib diisi.',
            'tujuan_kunjungan.required' => 'Tujuan kunjungan wajib diisi.',
        ]);

        $data = [
            'pengunjung_id' => $request->pengunjung_id,
            'tanggal_utama' => $request->tanggal_utama,
            'tanggal_alternatif' => $request->tanggal_alternatif,
            'tanggal_disetujui' => $request->tanggal_utama, // Langsung set sebagai tanggal disetujui
            'jumlah_peserta' => $request->jumlah_peserta,
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'status' => StatusKunjungan::DIKONFIRMASI, // Langsung dikonfirmasi karena dibuat admin
        ];

        // Handle file upload jika ada
        if ($request->hasFile('surat_permohonan')) {
            $data['surat_permohonan'] = $request->file('surat_permohonan')
                ->store('surat-permohonan', 'public');
        }

        $kunjungan = Kunjungan::create($data);

        // Kirim notifikasi email
        try {
            Mail::to($kunjungan->pengunjung->email)->send(
                new KunjunganStatusChanged(
                    $kunjungan,
                    'Admin telah membuat kunjungan untuk Anda. Kunjungan telah dikonfirmasi dan siap untuk ditugaskan petugas.'
                )
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send email: ' . $e->getMessage());
        }

        return redirect()->route('admin.kunjungan.show', $kunjungan)
            ->with('success', 'Kunjungan berhasil dibuat!');
    }
}