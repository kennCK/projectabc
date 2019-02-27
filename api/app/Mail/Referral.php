<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class Referral extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $date;
    public $referrerMessage;
    public $toEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $referrerMessage, $toEmail)
    {
        $this->user = $user;
        $this->referrerMessage = $referrerMessage;
        $this->toEmail = $toEmail;
        $this->date = Carbon::now()->copy()->tz('Asia/Manila')->format('F j, Y');
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->from('support@idfactory.ph')->view('email.referral');
    }
}
