<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NextWeekProgramme extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $events;

    /**
     * Create a new message instance.
     *
     * @param mixed $events
     */
    public function __construct($events)
    {
        $this->events = $events;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.weekly');
    }
}
