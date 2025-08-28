<?php

namespace App\Jobs;

use App\Mail\SendEmailOtp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Queueable;
    protected $data;
    protected $otp;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $otp)
    {
        $this->data = $data;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new SendEmailOtp($this->otp);
        Mail::to($this->data['email'])->send($email);
    }
}
