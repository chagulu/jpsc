<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $value;
    protected $otp;

    /**
     * Create a new job instance.
     */
    public function __construct($type, $value, $otp)
    {
        $this->type  = $type;
        $this->value = $value;
        $this->otp   = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->type === 'mobile') {
            // 📱 Send SMS (integrate MSG91/Twilio etc.)
            Log::info("Queued: Sending OTP {$this->otp} to mobile {$this->value}");
        } else {
            // 📧 Send Email
            Mail::raw("Your OTP is: {$this->otp}", function ($message) {
                $message->to($this->value)
                        ->subject("Your OTP Code");
            });
            Log::info("Queued: Sending OTP {$this->otp} to email {$this->value}");
        }
    }
}
