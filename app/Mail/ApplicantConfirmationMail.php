<?php

namespace App\Mail;

use App\Models\Applicant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class ApplicantConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $applicant;
    public $signedUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Applicant $applicant)
    {
        $this->applicant = $applicant;
        // Tworzymy jednorazowy, podpisany URL (ważny 24 h)
        $this->signedUrl = URL::temporarySignedRoute(
            'applicants.confirm',
            now()->addHours(24),
            ['applicant' => $applicant->id]
        );
    }

    // using envelope()/content() API only

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Potwierdzenie zgłoszenia',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.applicant-confirmation',
            with: [
                'url' => $this->signedUrl,
                'email' => $this->applicant->email,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
