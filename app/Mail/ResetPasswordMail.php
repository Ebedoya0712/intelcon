<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperación de Contraseña - Intelcon',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // La clave está en este método 'with'.
        // Aquí le pasamos la variable 'url' a la vista.
        return new Content(
            markdown: 'emails.reset-password',
            with: [
                'url' => url(route('password.reset', ['token' => $this->token])),
            ],
        );
    }
}
