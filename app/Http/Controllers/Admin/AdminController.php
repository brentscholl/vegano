<?php

namespace App\Http\Controllers\Admin;

use App\Box;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    /**
     * Show the Dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard() {
        // Get Orders
        $orders = Box::all();

        // Get Canadian Orders
        $canadianOrders = Box::whereHas('user', function($u) {
            $u->whereHas('shipping', function ($s)  {
                    $s->where('country', 'Canada');
            });
        })->get();

        // Get American Orders
        $americanOrders = Box::whereHas('user', function($u) {
            $u->whereHas('shipping', function ($s)  {
                $s->where('country', 'United States');
            });
        })->get();

        // Get all Subscribers
        $subscribers = User::whereHas('subscriptions', function ($s) {
            $s->whereNested(function ($t) {
                $t->where('name', 'standard')// name of subscription
                ->whereNull('ends_at')
                    ->orWhere('ends_at', '>', Carbon::now())
                    ->orWhereNotNull('trial_ends_at')
                    ->where('trial_ends_at', '>', Carbon::today());
            });
        })->get();

        // Get Canadian Subscribers
        $canadianSubscribers = User::whereHas('shipping', function($e){
            $e->where('country', 'Canada');
        })
            ->whereHas('subscriptions', function ($s) {
            $s->whereNested(function ($t) {
                $t->where('name', 'standard')// name of subscription
                ->whereNull('ends_at')
                    ->orWhere('ends_at', '>', Carbon::now())
                    ->orWhereNotNull('trial_ends_at')
                    ->where('trial_ends_at', '>', Carbon::today());
            });
        })->get();

        // Get American Subscribers
        $americanSubscribers = User::whereHas('shipping', function($e){
            $e->where('country', 'United States');
        })
            ->whereHas('subscriptions', function ($s) {
                $s->whereNested(function ($t) {
                    $t->where('name', 'standard')// name of subscription
                    ->whereNull('ends_at')
                        ->orWhere('ends_at', '>', Carbon::now())
                        ->orWhereNotNull('trial_ends_at')
                        ->where('trial_ends_at', '>', Carbon::today());
                });
            })->get();

        return view('admin.dashboard', compact('subscribers', 'orders', 'canadianOrders', 'americanOrders', 'canadianSubscribers', 'americanSubscribers'));
    }
}
