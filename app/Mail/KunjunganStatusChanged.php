<?php

namespace App\Mail;

use App\Models\Kunjungan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KunjunganStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Kunjungan $kunjungan,
        public string $pesan   // ⬅️ GANTI NAMA
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Perubahan Status Kunjungan - Stasiun Klimatologi',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.kunjungan-status-changed',
            with: [
                'kunjungan' => $this->kunjungan,
                'pesan'     => $this->pesan,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
