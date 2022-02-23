<?php

namespace App\Console\Commands;

use App\Box;
use App\Mail\BoxReminder;
use App\Mail\BoxShipped;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RemindUsersAboutBoxCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vegano:remind-users-about-box';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a reminder email to all users who have a box that will be ordered on wednesday';

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
        // It Tuesday. Get next sunday
        $date = Carbon::parse('next sunday')->toDateString();

        // Get open boxes (not skipped)
        $boxes = Box::with('user')->where('status', 'open')->where('start_date', $date)->get();

        // Send a email to all box owners
        foreach ($boxes as $box){
            \Mail::to($box->user)->queue(new BoxReminder($box->user));
        }
    }
}
