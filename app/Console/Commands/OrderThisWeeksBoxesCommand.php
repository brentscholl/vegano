<?php

namespace App\Console\Commands;

use App\Box;
use App\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderThisWeeksBoxesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vegano:order-this-weeks-boxes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Orders the boxes for the week.';

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
     * todo: email user and let them know box is ordered
     */
    public function handle()
    {
        // It is thursday morning. Get boxes for next sunday
        $date = Carbon::parse('next sunday')->toDateString();

        $boxes = Box::where('status', 'open')->where('start_date', $date)->get();

        DB::beginTransaction();

        // Order the boxes
        foreach ($boxes as $box){
            $box->status = 'ordered';
            $box->order_status = 'pending';
            $box->save();
            // Send user an email to let them know their box is ordered
        }

        DB::commit();

    }
}
