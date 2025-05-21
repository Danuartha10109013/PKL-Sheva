<?php
// app/Mail/LaunchMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LaunchMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('Project has Launched')
                    ->view('emails.launch') // ganti dengan view email kamu
                    ->with('data', $this->data);
    }
}
