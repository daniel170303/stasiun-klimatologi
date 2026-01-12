<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Kunjungan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 24px;">Stasiun Klimatologi IV</h1>
        <p style="color: #f0f0f0; margin: 10px 0 0 0;">Sistem Penjadwalan Kunjungan</p>
    </div>
    
    <div style="background: #ffffff; padding: 30px; border: 1px solid #e0e0e0; border-top: none;">
        <p style="font-size: 16px; margin-bottom: 20px;">
            Yth. <strong>{{ $kunjungan->pengunjung->nama_penanggung_jawab }}</strong>
        </p>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
    <p style="margin: 0 0 10px 0; font-size: 15px;">
        {{ $pesan }}
    </p>
</div>  
        <div style="background: #fff; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin: 0 0 15px 0; color: #667eea; font-size: 18px;">Detail Kunjungan</h3>
            
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%;">Instansi</td>
                    <td style="padding: 8px 0;">: {{ $kunjungan->pengunjung->nama_instansi }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Status</td>
                    <td style="padding: 8px 0;">: {{ $kunjungan->status->label() }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Tanggal Utama</td>
                    <td style="padding: 8px 0;">: {{ $kunjungan->tanggal_utama->format('d F Y') }}</td>
                </tr>
                @if($kunjungan->tanggal_disetujui)
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Tanggal Disetujui</td>
                    <td style="padding: 8px 0;">: {{ $kunjungan->tanggal_disetujui->format('d F Y') }}</td>
                </tr>
                @endif
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Jumlah Peserta</td>
                    <td style="padding: 8px 0;">: {{ $kunjungan->jumlah_peserta }} orang</td>
                </tr>
            </table>
            
            @if($kunjungan->petugas->count() > 0)
            <div style="margin-top: 20px;">
                <p style="font-weight: bold; margin-bottom: 10px;">Petugas yang Ditugaskan:</p>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($kunjungan->petugas as $petugas)
                    <li style="margin-bottom: 5px;">{{ $petugas->nama }} ({{ $petugas->keahlian }})</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            @if($kunjungan->keterangan_admin)
            <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
                <p style="margin: 0; font-weight: bold; color: #856404;">Keterangan Admin:</p>
                <p style="margin: 10px 0 0 0; color: #856404;">{{ $kunjungan->keterangan_admin }}</p>
            </div>
            @endif
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('pengunjung.kunjungan.show', $kunjungan) }}" 
               style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Lihat Detail Kunjungan
            </a>
        </div>
        
        <p style="color: #666; font-size: 14px; margin-top: 30px;">
            Jika Anda memiliki pertanyaan, silakan hubungi kami melalui email atau telepon yang tertera di website.
        </p>
    </div>
    
    <div style="background: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; border: 1px solid #e0e0e0; border-top: none;">
        <p style="margin: 0; color: #666; font-size: 13px;">
            &copy; {{ date('Y') }} Stasiun Klimatologi IV. Semua hak dilindungi.
        </p>
        <p style="margin: 10px 0 0 0; color: #999; font-size: 12px;">
            Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
        </p>
    </div>
</body>
</html>