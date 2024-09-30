<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendQuoteToSupplier extends Mailable
{
    use Queueable, SerializesModels;

    public $supplier, $lines, $user;

    /**
     * Create a new message instance.
     */
    public function __construct($supplier,$lines,$user){
        //
        $this->supplier = $supplier;
        $this->lines = $lines;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope{
        return new Envelope(
            from: new Address('noreplypo@ykm.com.mx',$this->user->name),
            subject: 'Cotización YKM',
            cc: [new Address($this->user->email)], // Añade las direcciones de CC aquí
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content{
        return (new Content())->with('supplier', $this->supplier)
                                ->with('line',$this->lines)
                                ->with('user',$this->user)
                            ->view('emails.send_quote_to_supplier');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array{
        return [];
    }
}
