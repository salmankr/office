<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class testMail extends Mailable
{
    use Queueable, SerializesModels;

    public $obj;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->obj);
        return $this->from($this->obj['from'])->html($this->obj['body']);
    }
}
