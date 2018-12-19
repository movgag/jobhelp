<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;

        $job_title = $data['job_title'];
        $new_status = $data['new_status'];

        return $this->from(env('MAIL_USERNAME'),'JobHelp Support Team')
            ->subject($data['subject'])
            ->view($data['view'],compact('job_title','new_status'));
    }
}
