<?php

namespace App\Mail;

use App\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CouponEarlyBird extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $coupon;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Welcome To Vegano! Redeem Your Subscription.');

        return $this->markdown('emails.coupon-early-bird');
    }
}
