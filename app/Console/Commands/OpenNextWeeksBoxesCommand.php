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

class OpenNextWeeksBoxesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vegano:open-next-weeks-boxes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Opens the boxes for next week.';

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
        DB::beginTransaction();

        // Get the sunday that is 5 weeks from now. This is the next week to open a box
        $start_date = Carbon::parse('next sunday')->addWeeks(4)->toDateString();

        // Get Users that are subscribed
        $users = User::with('shipping')->whereHas('subscriptions', function ($s) {
            $s->whereNested(function ($t) {
                $t->where('name', 'standard')// name of subscription
                    ->whereNull('ends_at')
                    ->orWhere('ends_at', '>', \Carbon\Carbon::now())
                    ->orWhereNotNull('trial_ends_at')
                    ->where('trial_ends_at', '>', Carbon::today());
            });
        })->get();

        // Go through each user
        foreach($users as $user){

            // Create the box
            $box = Box::create([
                'user_id' => $user->id,
                'status' => 'open',
                'start_date' => $start_date,
            ]);

            // Fill it will the proper meals based on the users shipping country
            if($user->shipping->country == "United States"){
                $meals = Meal::active()->whereHas('countries', function($e){
                    $e->where('code', 'usa');
                })->inRandomOrder()
                    ->limit(3)
                    ->get();
            }else{
                $meals = Meal::active()->whereHas('countries', function($e){
                    $e->where('code', 'cad');
                })->inRandomOrder()
                    ->limit(3)
                    ->get();
            }

            // Update Inventory and create a meal item for each meal. This adds 3 meals to the box
            foreach ($meals as $m){
                $m->inventory = $m->inventory - 1;
                $m->save();
                BoxItem::create([
                    'box_id' => $box->id,
                    'itemable_type' => 'App\Meal',
                    'itemable_id' => $m->id
                ]);
            }

        }

        DB::commit();

    }
}
