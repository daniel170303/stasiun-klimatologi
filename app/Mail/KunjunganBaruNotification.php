<?php

namespace App\Mail;

use App\Models\Kunjungan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KunjunganBaruNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Kunjungan $kunjungan
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan Kunjungan Baru - ' . $this->kunjungan->pengunjung->nama_instansi,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.kunjungan-baru-notification',
            with: [
                'kunjungan' => $this->kunjungan,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}