<?php

namespace App\Console\Commands;

use App\Coupon;
use App\Mail\CouponEarlyBird;
use Illuminate\Console\Command;

class SendCouponsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vegano:send-coupons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out all the coupons';

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
        // Get coupons that have not been sent
        $coupons = Coupon::where('sent', '0')->get();

        foreach($coupons as $c){

            // Set the email as the coupon email
            $to = [
                [
                    'email' => $c->email,
                    'name' => 'Vegano',
                ],
            ];

            // Send the email
            \Mail::to($to)->queue(new CouponEarlyBird($c));

            // Update sent
            $c->sent = 1;
            $c->save();
        }
    }
}
