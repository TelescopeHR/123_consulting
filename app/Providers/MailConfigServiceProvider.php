<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		try {
			$settings = DB::table('settings')->pluck('value', 'name');
			if (!$settings->isEmpty()) {
				Config::set('mail.mailers.smtp.host', isset($settings['mail_host']) ? $settings['mail_host'] : env('MAIL_HOST', 'smtp.mailtrap.io'));
				Config::set('mail.mailers.smtp.port', isset($settings['mail_port']) ? $settings['mail_port'] : env('MAIL_PORT', 587));
				Config::set('mail.mailers.smtp.encryption', isset($settings['mail_encryption']) ? $settings['mail_encryption'] : env('MAIL_ENCRYPTION', 'tls'));
				Config::set('mail.mailers.smtp.username', isset($settings['username']) ? $settings['username'] : env('MAIL_USERNAME'));
				Config::set('mail.mailers.smtp.password', isset($settings['password']) ? $settings['password'] : env('PASSWORD'));
				Config::set('mail.mailers.smtp.from.address', isset($settings['mail_address']) ? $settings['mail_address'] : env('MAIL_FROM_ADDRESS', 'hello@example.com'));
				Config::set('mail.mailers.smtp.from.name', isset($settings['mailer_name']) ? $settings['mailer_name'] : env('MAIL_FROM_NAME', 'Example'));

				// Login with google
				Config::set('services.google.client_id', isset($settings['google_clientid']) ? $settings['google_clientid'] : env('GOOGLE_CLIENT_ID'));
				Config::set('services.google.client_secret', isset($settings['google_secret']) ? $settings['google_secret'] : env('GOOGLE_CLIENT_SECRET'));
				Config::set('services.google.redirect', url('callback'));

				// google recaptcha v2
				Config::set('captcha.sitekey', isset($settings['g_recaptcha_key']) ? $settings['g_recaptcha_key'] : env('NOCAPTCHA_SECRET'));
				Config::set('captcha.secret', isset($settings['g_recaptcha_secret']) ? $settings['g_recaptcha_secret'] : env('NOCAPTCHA_SITEKEY'));

				// add stripe environment for subscription
				Config::set('cashier.key', isset($settings['publishable_key']) ? $settings['publishable_key'] : env('STRIPE_KEY'));
				Config::set('cashier.secret', isset($settings['stripe_key']) ? $settings['stripe_key'] : env('STRIPE_SECRET'));
			}
		} catch (Exception $e) {
		}
	}
}
