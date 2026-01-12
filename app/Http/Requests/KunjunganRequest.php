<?php

namespace App\Http\Requests;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class KunjunganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal_utama' => [
                'required', 
                'date', 
                'after:today',
                function ($attribute, $value, $fail) {
                    if ($this->isDateOccupied($value)) {
                        $fail('Tanggal ' . Carbon::parse($value)->format('d F Y') . ' sudah ada kunjungan yang diverifikasi. Silakan pilih tanggal lain.');
                    }
                },
            ],
            'tanggal_alternatif' => [
                'nullable', 
                'date', 
                'after:today',
                function ($attribute, $value, $fail) {
                    if ($value && $this->isDateOccupied($value)) {
                        $fail('Tanggal alternatif ' . Carbon::parse($value)->format('d F Y') . ' sudah ada kunjungan yang diverifikasi. Silakan pilih tanggal lain.');
                    }
                },
            ],
            'jumlah_peserta' => ['required', 'integer', 'min:1', 'max:100'],
            'tujuan_kunjungan' => ['required', 'string', 'max:1000'],
            'surat_permohonan' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_utama.required' => 'Tanggal utama wajib diisi.',
            'tanggal_utama.after' => 'Tanggal utama harus setelah hari ini.',
            'tanggal_alternatif.after' => 'Tanggal alternatif harus setelah hari ini.',
            'jumlah_peserta.required' => 'Jumlah peserta wajib diisi.',
            'jumlah_peserta.min' => 'Jumlah peserta minimal 1 orang.',
            'jumlah_peserta.max' => 'Jumlah peserta maksimal 100 orang.',
            'tujuan_kunjungan.required' => 'Tujuan kunjungan wajib diisi.',
            'surat_permohonan.required' => 'Surat permohonan wajib diunggah.',
            'surat_permohonan.mimes' => 'Surat permohonan harus berformat PDF.',
            'surat_permohonan.max' => 'Ukuran file maksimal 2MB.',
        ];
    }

    /**
     * Check if date is already occupied by verified visit
     */
    private function isDateOccupied($date): bool
    {
        return Kunjungan::where(function($query) use ($date) {
            $query->where('tanggal_disetujui', $date)
                  ->whereIn('status', [
                      'menunggu_konfirmasi',
                      'dikonfirmasi', 
                      'petugas_ditugaskan',
                      'terlaksana'
                  ]);
        })->exists();
    }
}