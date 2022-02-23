<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckUserSubscriptionDatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vegano:check-user-subscription-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the user has a subscription start date past due. If so updates their subscription';

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
        // Get todays date
        $date = Carbon::parse('today')->toDateString();

        // Get users with Paid Subscriptions start dates that are over
        $users = User::with('shipping')->where('paid_subscription_start_date', '<', $date)->get();

        // Update each user
        foreach ($users as $user){

            // Check Country so we can subscribe them to proper pricing subscription
            if($user->shipping->country == 'United States'){
                $user->subscription('standard')->swap(config('company.standard-usa-subscription-plan-id'));
            }else{
                $user->subscription('standard')->swap(config('company.standard-subscription-plan-id'));
            }

            // Remove Paid Subscription Start Date
            $user->paid_subscription_start_date = null;

            // Save
            $user->save();

        }
    }
}
