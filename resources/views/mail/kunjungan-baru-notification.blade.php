<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Kunjungan Baru</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 24px;">Stasiun Klimatologi IV</h1>
        <p style="color: #f0f0f0; margin: 10px 0 0 0;">Sistem Penjadwalan Kunjungan</p>
    </div>
    
    <div style="background: #ffffff; padding: 30px; border: 1px solid #e0e0e0; border-top: none;">
        <p style="font-size: 16px; margin-bottom: 20px;">
            Halo <strong>Admin</strong>,
        </p>
        
        <div style="background: #e8f4fd; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3498db;">
            <p style="margin: 0; font-size: 15px;">
                Telah masuk pengajuan kunjungan baru dari instansi <strong>{{ $kunjungan->pengunjung->nama_instansi }}</strong>.
                <br>Mohon segera diperiksa dan diproses.
            </p>
        </div>  

        <div style="background: #fff; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin: 0 0 15px 0; color: #667eea; font-size: 18px;">Detail Pengajuan</h3>
            
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%;">Instansi</td>
                    <td style="padding: 8px 0;">: {{ $kunjungan->pengunjung->nama_instansi }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Penanggung Jawab</td>
                    <td style="padding: 8px 0;">: {{ $kunjungan->pengunjung->nama_penanggung_jawab }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Tanggal Diajukan</td>
                    <td style="padding: 8px 0;">: {{ $kunjungan->created_at->format('d F Y H:i') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Rencana Tanggal</td>
                    <td style="padding: 8px 0;">: {{ $kunjungan->tanggal_utama->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Jumlah Peserta</td>
                    <td style="padding: 8px 0;">: {{ $kunjungan->jumlah_peserta }} orang</td>
                </tr>
            </table>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('admin.kunjungan.show', $kunjungan) }}" 
               style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Periksa Kunjungan
            </a>
        </div>
    </div>
    
    <div style="background: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; border: 1px solid #e0e0e0; border-top: none;">
        <p style="margin: 0; color: #666; font-size: 13px;">
            &copy; {{ date('Y') }} Stasiun Klimatologi IV.
        </p>
    </div>
</body>
</html>
