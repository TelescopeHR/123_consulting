<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Traits\SendEmail;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class sendPasswordDetailsEmail extends Command
{
	use SendEmail;
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'send-password-details';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		try {
			$users = User::where('is_password_sent', 0)->orderBy(DB::raw('YEAR(created_at)'), 'DESC')->limit(100)->get();

			$now = Carbon::now();
			if (!$users->isEmpty()) {
				foreach ($users as $key_user => $user) {
					$this->sendPasswordDetailsEmail($now, $user);
				}
			}
		} catch (Exception $e) {
			$this->line($e->getMessage());
		}
	}
}
