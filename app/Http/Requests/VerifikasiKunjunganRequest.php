<?php

namespace App\Http\Requests;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class VerifikasiKunjunganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal_disetujui' => [
                'required', 
                'date', 
                'after:today',
                function ($attribute, $value, $fail) {
                    $currentKunjunganId = $this->route('kunjungan')->id;
                    
                    if ($this->isDateOccupied($value, $currentKunjunganId)) {
                        $fail('Tanggal ' . Carbon::parse($value)->format('d F Y') . ' sudah ada kunjungan lain yang dijadwalkan. Silakan pilih tanggal lain.');
                    }
                },
            ],
            'keterangan_admin' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_disetujui.required' => 'Tanggal yang disetujui wajib diisi.',
            'tanggal_disetujui.after' => 'Tanggal harus setelah hari ini.',
        ];
    }

    /**
     * Check if date is already occupied by another verified visit
     */
    private function isDateOccupied($date, $excludeId = null): bool
    {
        $query = Kunjungan::where('tanggal_disetujui', $date)
                          ->whereIn('status', [
                              'menunggu_konfirmasi',
                              'dikonfirmasi', 
                              'petugas_ditugaskan',
                              'terlaksana'
                          ]);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}