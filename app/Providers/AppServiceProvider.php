<?php

namespace App\Providers;

use App\Box;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use \Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // custom image validation rule
        Validator::extend('image64', function ($attribute, $value, $parameters, $validator) {
            $type = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];
            if (in_array($type, $parameters)) {
                return true;
            }
            return false;
        });

        Validator::replacer('image64', function($message, $attribute, $rule, $parameters) {
            return str_replace(':values',join(",",$parameters),$message);
        });

        // Show the User's box in all views
        //compose all the views....
        view()->composer(['components.box-modal'], function ($view) {
            if(Auth::user() && !Auth::user()->isAdmin()){
                $box_dates_start = Carbon::parse('next Sunday')->addWeeks(-1)->toDateString();
                $boxes = Box::with('boxItems')
                    ->where('user_id', Auth::user()->id)
                    ->where('start_date', '>=', $box_dates_start)
                    ->get();
            }else{
                $boxes = null;
            }
            $view->with('boxes', $boxes );
        });
    }
}
