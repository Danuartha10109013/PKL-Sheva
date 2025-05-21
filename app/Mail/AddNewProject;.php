<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddNewProject extends Mailable
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
