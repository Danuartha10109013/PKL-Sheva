<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AddNewProjectMail extends Mailable
{
    use Queueable, SerializesModels;

  public $project;

    public function __construct($project)
    {
        $this->project = $project;
    }

    public function build()
    {
        return $this->subject('Permintaan Data Invoice untuk Proyek Baru')
                    ->view('emails.new_project');
    }
}
