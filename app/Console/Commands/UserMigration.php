<?php

namespace App\Console\Commands;

use App\Models\OldPurchase;
use App\Models\User;
use App\Models\VerifyUser;
use App\Traits\SendEmail;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserMigration extends Command
{
	use SendEmail;
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'migrate:users';

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
			$wp_users = DB::connection('mysql2')->table('wp_users')->get();
			$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

			if ($wp_users) {
				foreach ($wp_users as $key_user => $wp_user) {
					$password = $wp_user->user_login.'@2023';
					$first_name = '';
					$last_name = '';
					$agency_name = '';
					$phone = '';
					$address = '';
					$city = '';
					$zip_code = '';
					$wp_user_meta = DB::connection('mysql2')->table('wp_usermeta')->where('user_id', $wp_user->ID)->get();

					if ($wp_user_meta) {
						foreach ($wp_user_meta as $key_user_meta => $user_meta) {
							$first_name = $user_meta->meta_key == 'first_name' ? $user_meta->meta_value : $first_name;
							$last_name = $user_meta->meta_key == 'last_name' ? $user_meta->meta_value : $last_name;
							$agency_name = $user_meta->meta_key == 'user_agency_name' ? $user_meta->meta_value : $agency_name;
							$phone = $user_meta->meta_key == 'user_registration_user_phone' ? $user_meta->meta_value : ($user_meta->meta_key == 'user_phone' ? $user_meta->meta_value : $phone);
							$address = $user_meta->meta_key == 'billing_address_1' ? $user_meta->meta_value : $address;
							$address .= $user_meta->meta_key == 'billing_address_2' ? $user_meta->meta_value : $address;
							$city = $user_meta->meta_key == 'billing_city' ? $user_meta->meta_value : $city;
							$zip_code = $user_meta->meta_key == 'billing_postcode' ? $user_meta->meta_value : $zip_code;
						}
					}

					$this->line($wp_user->user_email);
					$this->line(Carbon::parse($wp_user->user_registered)->format('Y-m-d H:i:s'));

					$user = User::where('email', $wp_user->user_email)->first();
					if ($user) {
						User::where('email', $wp_user->user_email)->update([
							'email_verified_at' => now(),
							'parent_id' => NULL,
							'first_name' => $first_name,
							'last_name' => $last_name,
							'password' => Hash::make($password),
							'agency_name' => $agency_name,
							'username' => $wp_user->user_login,
							'phone' => $phone,
							'address' => $address,
							'city' => $city,
							'zipcode' => $zip_code,
							'status' => 1,
							'is_password_sent' => 0,
							'last_login' => NULL,
							'created_at' => $wp_user->user_registered ? Carbon::parse($wp_user->user_registered) : Carbon::now(),
							'updated_at' => $wp_user->user_registered ? Carbon::parse($wp_user->user_registered) : Carbon::now(),
						]);
					} else {
						DB::table('users')->insert([
							'email' => $wp_user->user_email,
							'email_verified_at' => now(),
							'parent_id' => NULL,
							'first_name' => $first_name,
							'last_name' => $last_name,
							'password' => Hash::make($password),
							'agency_name' => $agency_name,
							'username' => $wp_user->user_login,
							'phone' => $phone,
							'address' => $address,
							'city' => $city,
							'zipcode' => $zip_code,
							'status' => 1,
							'is_password_sent' => 0,
							'last_login' => NULL,
							'created_at' => $wp_user->user_registered ? Carbon::parse($wp_user->user_registered) : Carbon::now(),
							'updated_at' => $wp_user->user_registered ? Carbon::parse($wp_user->user_registered) : Carbon::now(),
						]);

						$user = User::where('email', $wp_user->user_email)->first();
						VerifyUser::create([
							'user_id' => $user->id,
							'token' => sha1(time())
						]);

						$role = Role::updateOrCreate(['name' => Config::get('constants.users_roles.customer')]);
						$user->assignRole($role);

						// Create Stripe Customer
						$user->createAsStripeCustomer([
							'name' => $user->first_name . ' ' . $user->last_name,
							'email' => $user->email
						]);
					}
				}
			}
		} catch (Exception $e) {
			$this->line("Could not open connection to database server. Please check your configuration.");
		}

		/* Start: import old user purchased course data */
		if (file_exists(public_path('old_user_data_for_laravel.csv'))) {
			$file = fopen(public_path('old_user_data_for_laravel.csv'), 'r');
			OldPurchase::truncate();
			while (($line = fgetcsv($file)) !== FALSE) {
				//$line is an array of the csv elements
				$user = User::where('email', $line[1])->first();

				$this->line($line[1]);

				OldPurchase::create([
					'old_user_id' => $line[0],
					'user_id' => $user ? $user->id : NULL,
					'email' => $line[1],
					'course' => $line[2],
					'completed_date' => $line[3] ?: null
				]);
			}
			fclose($file);
		}
		/* End: import old user purchased course data */
	}
}
