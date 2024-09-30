<?php

namespace App\Mail;

use App\Models\RequestQuote;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationForApproval extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $request_quote, $user;
    public function __construct(RequestQuote $request_quote, User $user)
    {
        $this->request_quote = $request_quote;
        $this->user = $user;
    }
    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope{
        return new Envelope(
            from: new Address('noreplypo@ykm.com.mx','GESC'),
            subject: 'Aprobación Pendiente',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content{
        return (new Content())->with('supplier', $this->request_quote)
                                ->with('user',$this->user)
                            ->view('emails.send_released_quote_to_user');
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
