<?php

namespace App\Console\Commands;

use App\Box;
use App\BoxItem;
use App\Meal;
use App\Order;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SetSkippedUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vegano:set-skipped-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates A users subscription based on if they skipped next weeks box or not';

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
     * Update users who need to be skipped to skipped and update users who's skip is over back to their plan.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();

        // It's wednesday morning. Get next sunday.
        $date = Carbon::parse('next sunday')->toDateString();

        // Get users who are not yet skipped that have a box that has a skip
        $usersToSkip = User::where('paid_subscription_start_date', '==', null) // If they are on a free subscription dont change anything
            ->whereHas('subscriptions', function ($s) {
            $s->whereNested(function ($t) {
                $t->where('name', 'standard')// name of subscription
                    ->where('stripe_plan', config('company.standard-subscription-plan-id'))
                    ->orWhere('stripe_plan', config('company.standard-usa-subscription-plan-id'))
                    ->whereNull('ends_at')
                    ->orWhere('ends_at', '>', \Carbon\Carbon::now())
                    ->orWhereNotNull('trial_ends_at')
                    ->where('trial_ends_at', '>', Carbon::today());
            });
        })->whereHas('boxes', function($b) use($date) {
            $b->where('start_date', $date)->where('status', 'skipped');
        })->get();

        foreach($usersToSkip as $user){
            // Update each user found to a skipped price plan
            $user->subscription('standard')->swap(config('company.skipped-subscription-plan-id'));
        }

        // Get users who are skipped that have a box that is not skipped
        $usersToUnskip = User::with('shipping')->where('paid_subscription_start_date', '==', null) // If they are on a free subscription dont change anything
            ->whereHas('subscriptions', function ($s) {
            $s->whereNested(function ($t) {
                $t->where('name', 'standard')// name of subscription
                ->where('stripe_plan', config('company.skipped-subscription-plan-id'))
                    ->whereNull('ends_at')
                    ->orWhere('ends_at', '>', \Carbon\Carbon::now())
                    ->orWhereNotNull('trial_ends_at')
                    ->where('trial_ends_at', '>', Carbon::today());
            });
        })->whereHas('boxes', function($b) use($date) {
            $b->where('start_date', $date)->where('status', 'open');
        })->get();

        foreach($usersToUnskip as $user){
            // Put them back on the proper plan based on their country
            if($user->shipping->country == 'United States'){
                $user->subscription('standard')->swap(config('company.standard-usa-subscription-plan-id'));
            }else{
                $user->subscription('standard')->swap(config('company.standard-subscription-plan-id'));
            }
        }

        DB::commit();
    }
}
