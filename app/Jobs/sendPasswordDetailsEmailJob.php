<?php

namespace App\Jobs;

use App\Mail\sendPasswordDetailsMail;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class sendPasswordDetailsEmailJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	protected $user;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($user)
	{
		$this->user = $user;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		try {
			Mail::to($this->user->email)->send(new sendPasswordDetailsMail($this->user));
			User::where('email', $this->user->email)->update([
				'is_password_sent' => 1
			]);
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
	}
}
