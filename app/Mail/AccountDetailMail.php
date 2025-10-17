<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountDetailMail extends Mailable
{
	use Queueable, SerializesModels;

	protected $user;
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($user, $password)
	{
		$this->user = $user;
		$this->user['decrypted_password'] = $password;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('Verify Email')
			->markdown('emails.accountDetails')
			->with('user', $this->user);
	}
}
