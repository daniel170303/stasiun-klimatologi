<?php

namespace App\Exports;

use App\Models\Kunjungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KunjunganExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $dateRange;

    public function __construct($dateRange)
    {
        $this->dateRange = $dateRange;
    }

    public function collection()
    {
        return Kunjungan::with(['pengunjung', 'petugas'])
            ->whereBetween('created_at', $this->dateRange)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Pengajuan',
            'Nama Instansi',
            'Penanggung Jawab',
            'Email',
            'No. HP',
            'Tanggal Kunjungan',
            'Tanggal Disetujui',
            'Jumlah Peserta',
            'Tujuan',
            'Status',
            'Petugas',
            'Keterangan',
        ];
    }

    public function map($kunjungan): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $kunjungan->created_at->format('d/m/Y H:i'),
            $kunjungan->pengunjung->nama_instansi,
            $kunjungan->pengunjung->nama_penanggung_jawab,
            $kunjungan->pengunjung->email,
            $kunjungan->pengunjung->no_hp,
            $kunjungan->tanggal_utama->format('d/m/Y'),
            $kunjungan->tanggal_disetujui ? $kunjungan->tanggal_disetujui->format('d/m/Y') : '-',
            $kunjungan->jumlah_peserta,
            $kunjungan->tujuan_kunjungan,
            $kunjungan->status->label(),
            $kunjungan->petugas->pluck('nama')->join(', ') ?: '-',
            $kunjungan->keterangan_admin ?: '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 18,
            'C' => 30,
            'D' => 25,
            'E' => 25,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 10,
            'J' => 40,
            'K' => 20,
            'L' => 30,
            'M' => 30,
        ];
    }
}