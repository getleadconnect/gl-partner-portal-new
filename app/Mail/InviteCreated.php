<?php

namespace App\Mail;

use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteCreated extends Mailable
{
    use Queueable, SerializesModels;
    
    public $invite;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'GL-Partner Invitation',
        );
    }


    public function build()
    {
        return $this->view('invite_email')
                ->to($this->invite->email);
				
        //         ->cc(['info@winnerinyou.in'])
        //         ->with([
        //             'name' => $this->user['name'],
        //             'booking_date' => $this->user['booking_date'],
        //             'reference' => $this->user['reference'],
        // ]);
    }

    // public function build()
    // {
    //     return $this->from('theemail@gmail.com', 'Me')
    //         ->to($this->invite->email)
    //         ->view('invite_email');
    //         // ->with([
    //         //     'contact' => $this->contact
    //         // ]);
    //     // return $this->from('you@example.com')
    //     //             ->view('invite_email');
    // }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'invite_email',
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
