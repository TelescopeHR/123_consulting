<?php

namespace App\Jobs;

use App\Mail\ReminderMail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReminderMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->details['email'])->cc([
                'info@123consultingsolutions.com',
                'nikunj.goriya@coderscotch.com'
            ])->send(new ReminderMail([
                'subject' => $this->details['subject'],
                'body' => $this->details['body']
            ]));
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
