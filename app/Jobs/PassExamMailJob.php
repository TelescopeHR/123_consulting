<?php

namespace App\Jobs;

use App\Mail\PassExamMail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PassExamMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
			Mail::to('info@123consultingsolutions.com')->send(new PassExamMail([
				'certificate_name' => $this->data['certificate_name'],
				'course_purchased' => $this->data['course_purchased'],
				'company_email' => $this->data['company_email'],
				'company_phone' => $this->data['company_phone'],
				'course_name' => $this->data['course_name'],
				'quiz_name' => $this->data['quiz_name'],
                'marks' => $this->data['marks']
			]));
            
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
    }
}
