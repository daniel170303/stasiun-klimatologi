<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class DateAvailabilityController extends Controller
{
    /**
     * Get occupied dates for the next 3 months
     */
    public function getOccupiedDates()
    {
        $occupiedDates = Kunjungan::whereNotNull('tanggal_disetujui')
            ->whereIn('status', [
                'menunggu_konfirmasi',
                'dikonfirmasi',
                'petugas_ditugaskan',
                'terlaksana'
            ])
            ->where('tanggal_disetujui', '>=', now())
            ->where('tanggal_disetujui', '<=', now()->addMonths(3))
            ->pluck('tanggal_disetujui')
            ->map(function($date) {
                return $date->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->toArray();

        return response()->json([
            'occupied_dates' => $occupiedDates
        ]);
    }

    /**
     * Check if specific date is available
     */
    public function checkDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after:today'
        ]);

        $isOccupied = Kunjungan::where('tanggal_disetujui', $request->date)
            ->whereIn('status', [
                'menunggu_konfirmasi',
                'dikonfirmasi',
                'petugas_ditugaskan',
                'terlaksana'
            ])
            ->exists();

        return response()->json([
            'date' => $request->date,
            'is_occupied' => $isOccupied,
            'is_available' => !$isOccupied
        ]);
    }
}