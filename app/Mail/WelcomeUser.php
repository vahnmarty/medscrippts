<?php

namespace App\Mail;

use Arr;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use MailerSend\Helpers\Builder\Variable;
use Illuminate\Contracts\Queue\ShouldQueue;
use MailerSend\LaravelDriver\MailerSendTrait;

class WelcomeUser extends Mailable
{
    use Queueable, SerializesModels;

    use MailerSendTrait;

    public User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $variables = [
            new Variable($this->user->email, [
                'user.name' => $this->user->name,
                'support_email' => config('mail.from.address'),
                'site_url' => url('dashboard')
            ])
        ];

      
        return $this->mailersend('3yxj6ljnro0gdo2r', $variables);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome User',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.user.welcome',
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
