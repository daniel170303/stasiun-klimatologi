<?php

namespace App\Http\Requests;

use App\Models\Kunjungan;
use App\Enums\StatusKunjungan;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class KunjunganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggal_utama' => [
                'required', 
                'date', 
                'after:today',
                function ($attribute, $value, $fail) {
                    // Check if valid day (Monday-Thursday only)
                    if (!$this->isValidDay($value)) {
                        $dayName = Carbon::parse($value)->locale('id')->dayName;
                        $fail('Tanggal ' . Carbon::parse($value)->format('d F Y') . ' (' . $dayName . ') tidak dapat dipilih. Kunjungan hanya dapat dilakukan pada hari Senin sampai Kamis.');
                    }
                    
                    // Check if date is occupied
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
                    if ($value) {
                        // Check if valid day (Monday-Thursday only)
                        if (!$this->isValidDay($value)) {
                            $dayName = Carbon::parse($value)->locale('id')->dayName;
                            $fail('Tanggal alternatif ' . Carbon::parse($value)->format('d F Y') . ' (' . $dayName . ') tidak dapat dipilih. Kunjungan hanya dapat dilakukan pada hari Senin sampai Kamis.');
                        }
                        
                        // Check if date is occupied
                        if ($this->isDateOccupied($value)) {
                            $fail('Tanggal alternatif ' . Carbon::parse($value)->format('d F Y') . ' sudah ada kunjungan yang diverifikasi. Silakan pilih tanggal lain.');
                        }
                    }
                },
            ],
            'jumlah_peserta' => ['required', 'integer', 'min:1', 'max:100'],
            'tujuan_kunjungan' => ['required', 'string', 'max:1000'],
            'surat_permohonan' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
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
            'tujuan_kunjungan.max' => 'Tujuan kunjungan maksimal 1000 karakter.',
            'surat_permohonan.required' => 'Surat permohonan wajib diunggah.',
            'surat_permohonan.mimes' => 'Surat permohonan harus berformat PDF.',
            'surat_permohonan.max' => 'Ukuran file maksimal 2MB.',
        ];
    }

    /**
     * Check if date is a weekend (Saturday or Sunday)
     *
     * @param string $date
     * @return bool
     */
    private function isWeekend($date): bool
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        // 0 = Sunday, 6 = Saturday
        return in_array($dayOfWeek, [0, 6]);
    }

    /**
     * Check if date is valid day (Monday-Thursday only)
     *
     * @param string $date
     * @return bool
     */
    private function isValidDay($date): bool
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        // 1 = Monday, 2 = Tuesday, 3 = Wednesday, 4 = Thursday
        return in_array($dayOfWeek, [1, 2, 3, 4]);
    }

    /**
     * Check if date is already occupied by verified visit
     *
     * @param string $date
     * @return bool
     */
    private function isDateOccupied($date): bool
    {
        return Kunjungan::where('tanggal_disetujui', $date)
            ->whereIn('status', [
                StatusKunjungan::MENUNGGU_KONFIRMASI,
                StatusKunjungan::DIKONFIRMASI, 
                StatusKunjungan::PETUGAS_DITUGASKAN,
                StatusKunjungan::TERLAKSANA
            ])
            ->exists();
    }
}