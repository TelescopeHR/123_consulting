<?php

namespace App\Traits;

use App\Jobs\AgencySignUpEmailJob;
use App\Jobs\PassExamMailJob;
use App\Jobs\ReminderMailJob;
use App\Jobs\sendPasswordDetailsEmailJob;
use App\Jobs\WeeklyReportMailJob;
use App\Mail\AccountDetailMail;
use App\Mail\ContactMail;
use App\Mail\VerifyMail;
use App\Mail\WelcomeMail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait SendEmail
{
	/**
	 * Send email when user submit contact form.
	 *
	 * @param string $toEmail
	 * @param string $name
	 * @param string $email
	 * @param string $phone
	 * @param string $message
	 * @return boolean
	 */
	function sendContactEmail($toEmail, $name, $email, $phone, $message)
	{
		try {
			Mail::to($toEmail)->send(new ContactMail([
				'name' => $name,
				'email' => $email,
				'phone' => $phone,
				'message' => $message
			]));
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
		return true;
	}

	/**
	 * Send email for verify email on register
	 *
	 * @param string $toEmail
	 * @param object $user
	 * @return boolean
	 */
	function sendVerifyEmail($toEmail, $user)
	{
		try {
			Mail::to($toEmail)->send(new VerifyMail($user));
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
		return true;
	}

	/**
	 * Send email for verify email on register
	 *
	 * @param string $toEmail
	 * @param object $user
	 * @return boolean
	 */
	function sendAccountDetailsEmail($toEmail, $user, $password)
	{
		try {
			Mail::to($toEmail)->send(new AccountDetailMail($user, $password));
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
		return true;
	}

	/**
	 * Send welcome email to new user
	 *
	 * @param string $toEmail
	 * @param object $user
	 * @return boolean
	 */
	function sendWelcomeEmail($user)
	{
		try {
			Mail::to($user->email)->send(new WelcomeMail([
				'name' => $user->first_name . ' ' . $user->last_name,
				'email' => $user->email,
				'username' => $user->username,
				'password' => $user->password
			]));
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
		return true;
	}

	/**
	 * Send reminder email from CRON
	 *
	 * @param object $now
	 * @param object $user
	 * @param string $subject
	 * @param string $body
	 * @return boolean
	 */
	function sendReminderEmail($now, $user, $subject, $body)
	{
		try {
			dispatch(new ReminderMailJob([
				'email' => $user->email,
				'subject' => $subject,
				'body' => $body
			]))->delay($now->addSeconds(4));
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
		return true;
	}

	/**
	 * Send weekly report from CRON
	 *
	 * @param string $filename
	 * @param string $subject
	 * @return boolean
	 */
	function sendWeelyReportEmail($filename, $subject)
	{
		try {
			dispatch(new WeeklyReportMailJob([
				'filename' => $filename,
				'subject' => $subject
			]));
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
		return true;
	}

	function sendPasswordDetailsEmail($now, $user)
	{
		try {
			dispatch(new sendPasswordDetailsEmailJob($user))->delay($now->addSeconds(2));
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
		return true;
	}

	function agencySignUpEMail($user)
	{
		try {
			dispatch(new AgencySignUpEmailJob($user));
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
		return true;
	}

	function sendCompleteCourseEmail($data)
	{
		try {
			dispatch(new PassExamMailJob($data));
		} catch (Exception $e) {
			Log::info($e->getMessage());
		}
		return true;
	}
}
