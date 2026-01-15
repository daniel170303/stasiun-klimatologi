<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kunjungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .logo-cell {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }
        .title-cell {
            width: 70%;
            text-align: center;
            vertical-align: middle;
        }
        .spacer-cell {
            width: 15%;
        }
        .divider-thick {
            border: 1px solid #000;
            margin: 10px 0 6px;
        }
        .divider-thin {
            border: 0.5px solid #000;
            margin: 0;
        }
        .stats {
            margin: 20px 0;
            background: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
        }
        .stats-grid {
            display: table;
            width: 100%;
        }
        .stat-item {
            display: table-cell;
            width: 20%;
            text-align: center;
            padding: 10px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #4F46E5;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table.data-table th {
            background: #4F46E5;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        table.data-table td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        table.data-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        .status {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
        }
        .status-diajukan { background: #DBEAFE; color: #1E40AF; }
        .status-diverifikasi { background: #E0E7FF; color: #4338CA; }
        .status-menunggu_konfirmasi { background: #FEF3C7; color: #92400E; }
        .status-dikonfirmasi { background: #EDE9FE; color: #6B21A8; }
        .status-petugas_ditugaskan { background: #FCE7F3; color: #9F1239; }
        .status-terlaksana { background: #D1FAE5; color: #065F46; }
        .status-tidak_terlaksana { background: #FEE2E2; color: #991B1B; }
        .status-selesai { background: #F3F4F6; color: #374151; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <!-- Logo Column -->
                <td class="logo-cell">
                    <!-- Logo Placeholder dengan Gradient -->
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 50%, #60A5FA 100%); border-radius: 50%; display: inline-block; position: relative; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                            <!-- Cloud Icon -->
                            <div style="background: white; width: 35px; height: 20px; border-radius: 20px; margin: 0 auto 3px; position: relative;">
                                <div style="position: absolute; top: -8px; left: 8px; background: white; width: 18px; height: 18px; border-radius: 50%;"></div>
                            </div>
                            <!-- Text BMKG -->
                            <div style="color: white; font-size: 9px; font-weight: bold; font-family: Arial, sans-serif; letter-spacing: 1px;">
                                BMKG
                            </div>
                        </div>
                    </div>
                </td>
                
                <!-- Title Column -->
                <td class="title-cell">
                    <h1 style="margin: 0; font-size: 16px; font-weight: bold;">
                        BADAN METEOROLOGI, KLIMATOLOGI, DAN GEOFISIKA
                    </h1>
                    <h2 style="margin: 4px 0; font-size: 14px; font-weight: normal;">
                        Stasiun Klimatologi Kelas IV Yogyakarta
                    </h2>
                    <p style="margin: 2px 0; font-size: 10px; color: #333;">
                        Jl. Kabupaten No. Km. 5.5, Duwet, Sendangadi, Kec. Mlati, Kabupaten Sleman  
                    </p>
                    <p style="margin: 0; font-size: 10px; color: #333;">
                        Daerah Istimewa Yogyakarta 55285
                    </p>
                </td>
                
                <!-- Spacer Column -->
                <td class="spacer-cell"></td>
            </tr>
        </table>

        <hr class="divider-thick">
        <hr class="divider-thin">
        
        <h2 style="margin-top: 15px; font-size: 14px; font-weight: bold;">
            LAPORAN KUNJUNGAN
        </h2>
        <p style="margin: 5px 0; font-size: 11px; color: #555;">
            Periode: {{ $period }}
        </p>
    </div>

    <div class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ $statistik['total'] }}</div>
                <div class="stat-label">Total Kunjungan</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $statistik['diajukan'] }}</div>
                <div class="stat-label">Diajukan</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $statistik['terlaksana'] }}</div>
                <div class="stat-label">Terlaksana</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $statistik['tidak_terlaksana'] }}</div>
                <div class="stat-label">Tidak Terlaksana</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $statistik['total_peserta'] }}</div>
                <div class="stat-label">Total Peserta</div>
            </div>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Tanggal</th>
                <th width="20%">Instansi</th>
                <th width="15%">Penanggung Jawab</th>
                <th width="8%">Peserta</th>
                <th width="12%">Status</th>
                <th width="17%">Petugas</th>
                <th width="15%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kunjungan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tanggal_disetujui ? $item->tanggal_disetujui->format('d/m/Y') : $item->tanggal_utama->format('d/m/Y') }}</td>
                <td>{{ $item->pengunjung->nama_instansi }}</td>
                <td>{{ $item->pengunjung->nama_penanggung_jawab }}</td>
                <td style="text-align: center;">{{ $item->jumlah_peserta }}</td>
                <td>
                    <span class="status status-{{ $item->status->value }}">
                        {{ $item->status->label() }}
                    </span>
                </td>
                <td>{{ $item->petugas->pluck('nama')->join(', ') ?: '-' }}</td>
                <td>{{ Str::limit($item->keterangan_admin ?: '-', 50) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>
</body>
</html>