<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * @var mixed
	 */
	public $mail_data;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($mail_data)
	{
		$this->mail_data = $mail_data;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		if ($this->mail_data['invoice_pdf']) {
			return $this->subject('Payment successful for courses')
				->markdown('emails.invoice')
				->with('mail_data', $this->mail_data)
				->attach($this->mail_data['invoice_pdf']);
		} else {
			return $this->subject('Payment successful for courses')
				->markdown('emails.invoice')
				->with('mail_data', $this->mail_data);
		}
	}
}
