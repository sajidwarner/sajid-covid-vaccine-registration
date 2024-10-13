<?php

namespace App\Mail;

use App\Models\User;
use App\Models\VaccineCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VaccinationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $vaccineCenter;


    public function __construct(User $user, VaccineCenter $vaccineCenter)
    {
        $this->user = $user;
        $this->vaccineCenter = $vaccineCenter;
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.vaccination_reminder',
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
