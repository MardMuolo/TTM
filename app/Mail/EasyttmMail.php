<?php

namespace App\Mail;

use App\Models\MessageMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class EasyttmMail extends Mailable
{
    use Queueable, SerializesModels;

    //Message venant de la base des données
    public $user;
    public MessageMail $message ;

    public $url;

    public $path_to_attach = array();

    /**
     * Create a new message instance.
     */
    public function __construct($user, MessageMail $message, string $url, array $path_to_attach)
    {
        //Affectation du message depuis le constructeur
        $this->message = $message;
        $this->url = $url;
        $this->path_to_attach = $path_to_attach;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->message->object,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.easyTtm_mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $array = array();

        if($this->message->attachement == true){
            foreach($this->path_to_attach as $path){
                array_push($array, Attachment::fromPath($path));
            }
        }
        return $array;
        
    }
}
