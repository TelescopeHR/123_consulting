<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CouponMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $coupon_code;

    public function __construct($coupon_code)
    {
        $this->coupon_code = $coupon_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Coupon Code')
            ->markdown('emails.couponMail')
            ->with('coupon_code', $this->coupon_code);
    }
}
