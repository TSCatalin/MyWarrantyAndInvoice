<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $content = "<h2>Contact form message</h2>"
            . "<p>Name: " . e($this->data['first_name'] ?? 'N/A') . "</p>"
            . "<p>Email: " . e($this->data['email'] ?? 'N/A') . "</p>"
            . "<p>Message: " . e($this->data['message'] ?? 'N/A') . "</p>";

        return $this->subject('New Contact Form Submission')
            ->html($content);
    }
}
