<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $contactData;
    
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }
    
    public function build()
    {
        return $this->subject($this->contactData['subject'])
                    ->view('emails.contact', [
                        'name'            => $this->contactData['name'],
                        'email'           => $this->contactData['email'],
                        'subject'         => $this->contactData['subject'],
                        'contact_message' => $this->contactData['message'],
                    ]);
    }
}
