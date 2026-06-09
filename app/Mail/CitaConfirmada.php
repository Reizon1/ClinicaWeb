<?php

namespace App\Mail;

use App\Models\Cita;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CitaConfirmada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Cita $cita) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de Cita – Clínica Los Mollos',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.cita-confirmada',
            with: ['cita' => $this->cita],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
