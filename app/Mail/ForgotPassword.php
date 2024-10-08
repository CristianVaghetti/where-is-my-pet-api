<?php

namespace App\Mail;

use App\Models\Token;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    private User $user;
    private Token $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Token $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Alteração de senha',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $url = \env('URL_FRONT');
        return new Content(
            view: null, 
            html: null, 
            text: null, 
            markdown: 'mail.forgotPassword',
            with: [
                'url' => "{$url}/reset-password?token={$this->token->token}&forgot=1",
                'user' => $this->user
            ], 
            htmlString: null
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
