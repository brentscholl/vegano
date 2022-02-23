<?php

    namespace App\Http\Controllers\Auth;

    use App\Box;
    use App\BoxItem;
    use App\Coupon;
    use App\Http\Controllers\Controller;
    use App\Mail\Welcome;
    use App\Meal;
    use App\Providers\RouteServiceProvider;
    use App\User;
    use App\UserBilling;
    use App\UserShipping;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Validator;

    class RegisterController extends Controller
    {
        /*
        |--------------------------------------------------------------------------
        | Register Controller
        |--------------------------------------------------------------------------
        |
        | This controller handles the registration of new users as well as their
        | validation and creation.
        |
        */

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct() {
            $this->middleware('guest');
        }

        /**
         * Show the application registration form.
         *
         * @return \Illuminate\Http\Response
         */
        public function showRegistrationForm() {
            $user = new User;
            $intent = $user->createSetupIntent(); // For Stripe
            return view('auth.register', compact('intent'));
        }

        /**
         * Check and returns an existing coupon based on code.
         * @param \Illuminate\Http\Request $request
         * @return mixed
         */
        public function checkCoupon(Request $request) {
            $coupon = Coupon::where('token', $request->input('coupon_code'))->first();
            return $coupon;
        }

        /**
         * Handle a registration request for the application.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function register(Request $request) {

            // Rules
            $rules = [
                'first_name'           => 'required|string|min:2|max:12',
                'last_name'            => 'required|string|min:2|max:12',
                'email'                => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
                'phone_number'         => 'required|min:10|max:20|unique:users,phone_number,NULL,id,deleted_at,NULL',
                'password'             => 'required|string|min:6|confirmed',
                'shipping_address'     => 'required|string',
                'shipping_address_2'   => 'nullable|string',
                // 'shipping_country'     => 'required|string',
                // 'shipping_city'        => 'required|string',
                // 'shipping_state'       => 'required|string',
                'shipping_postal_code' => 'required|string',
                'delivery_instructions' => 'nullable|string',

                'terms' => 'accepted',
            ];

            // If their billing address is different than shipping
            if($request->input('billing_address_different')){
                $rules['billing_address']     = 'required|string';
                $rules['billing_address_2']   = 'nullable|string';
                $rules['billing_country']     = 'required|string';
                $rules['billing_city']        = 'required|string';
                $rules['billing_state']    = 'required|string';
                $rules['billing_postal_code'] = 'required|string';
            }

            $this->validate(request(), $rules);

            try {
                DB::beginTransaction();

                // Create the new user
                $user = User::create([
                    'first_name'   => $request->input('first_name'),
                    'last_name'    => $request->input('last_name'),
                    'email'        => $request->input('email'),
                    'phone_number' => $request->input('phone_number'),
                    'password'     => Hash::make($request->input('password')),
                ]);

                // Set Address based on their location
                if(inAmerica()){
                    $country = 'United States';
                    $state = 'California';
                    $city = 'Los Angeles';
                }else{
                    $country = 'Canada';
                    $state = 'British Columbia';
                    $city = 'Vancouver';
                }

                $shipping = UserShipping::create([
                    'user_id'               => $user->id,
                    'address_line_1'        => $request->input('shipping_address'),
                    'address_line_2'        => $request->input('shipping_address_2'),
                    'country'               => $country,
                    'city'                  => $city,
                    'state'                 => $state,
                    'postal_code'           => $request->input('shipping_postal_code'),
                    'delivery_instructions' => $request->input('delivery_instructions'),
                ]);

                if ( $request->input('billing_address_different') ) {
                    // Billing Address is different than Shipping Address
                    $billing = UserBilling::create([
                        'user_id'        => $user->id,
                        'address_line_1' => $request->input('billing_address'),
                        'address_line_2' => $request->input('billing_address_2'),
                        'country'        => $request->input('billing_country'),
                        'city'           => $request->input('billing_city'),
                        'state'          => $request->input('billing_state'),
                        'postal_code'    => $request->input('billing_postal_code'),
                    ]);
                } else {
                    // Billing Address is the same as Shipping Address
                    $billing = UserBilling::create([
                        'user_id'        => $user->id,
                        'address_line_1' => $request->input('shipping_address'),
                        'address_line_2' => $request->input('shipping_address_2'),
                        'country'        => $country,
                        'city'           => $city,
                        'state'          => $state,
                        'postal_code'    => $request->input('shipping_postal_code'),
                    ]);
                }
                // Attach relationship
                $user->user_shipping_id = $shipping->id;
                $user->user_billing_id = $billing->id;

                //Check for coupon
                $isFree = false;
                if($request->input('coupon_code')){
                    $coupon = Coupon::where('token', $request->input('coupon_code'))->first();
                    if($coupon){
                        // Coupon Found
                        $isFree = true;
                        $weeks = $coupon->amount;

                        // Set date
                        $paid_sub_start_date = Carbon::parse('next thursday')->addWeeks($weeks)->toDateString();
                        $user->paid_subscription_start_date = $paid_sub_start_date;

                        // Coupon used. Now delete it.
                        $coupon->delete();
                    }
                }

                // Subscribe the user
                $anchor = Carbon::parse('next thursday'); // All users get billed on Thursday

                if($isFree){ // User used a coupon
                    $user->newSubscription('standard', config('company.free-subscription-plan-id'))->anchorBillingCycleOn($anchor->startOfDay())->create($request->input('stripeToken'));
                }
                elseif(inAmerica()){ // User did not use a coupon and is in America
                    $user->newSubscription('standard', config('company.standard-usa-subscription-plan-id'))->anchorBillingCycleOn($anchor->startOfDay())->create($request->input('stripeToken'));
                }else { // User did not use a coupon and is not in America
                    $user->newSubscription('standard', config('company.standard-subscription-plan-id'))->anchorBillingCycleOn($anchor->startOfDay())->create($request->input('stripeToken'));
                }

                // Save the user
                $user->save();

                // Create user's box
                // $weekMap = [
                //     0 => 'SU',
                //     1 => 'MO',
                //     2 => 'TU',
                //     3 => 'WE',
                //     4 => 'TH',
                //     5 => 'FR',
                //     6 => 'SA',
                // ];
                $dayOfTheWeek = Carbon::now()->dayOfWeek;

                if($dayOfTheWeek > 3){ // if it is thursday, friday, or saturday. Set the 4 start dates for the first 4 boxes
                    $start_date = Carbon::parse('next sunday')->addWeek(1)->toDateString();
                    $start_date_2 = Carbon::parse('next sunday')->addWeek(2)->toDateString();
                    $start_date_3 = Carbon::parse('next sunday')->addWeek(3)->toDateString();
                    $start_date_4 = Carbon::parse('next sunday')->addWeek(4)->toDateString();
                }else{
                    $start_date = Carbon::parse('last sunday')->addWeek(1)->toDateString();
                    $start_date_2 = Carbon::parse('last sunday')->addWeek(2)->toDateString();
                    $start_date_3 = Carbon::parse('last sunday')->addWeek(3)->toDateString();
                    $start_date_4 = Carbon::parse('last sunday')->addWeek(4)->toDateString();
                }

                // Create 4 Boxes =======
                // Box 1
                $box1 = Box::create([
                    'user_id' => $user->id,
                    'status' => 'open',
                    'start_date' => $start_date,
                ]);
                $meals1 = Meal::active()->whereHas('countries', function($e){
                    if(inAmerica()){
                        $e->where('code', 'usa');
                    }else{
                        $e->where('code', 'cad');
                    }
                })->inRandomOrder()
                    ->limit(3)
                    ->get();
                foreach ($meals1 as $m){
                    $m->inventory = $m->inventory - 1;
                    $m->save();
                    BoxItem::create([
                        'box_id' => $box1->id,
                        'itemable_type' => 'App\Meal',
                        'itemable_id' => $m->id
                    ]);
                }

                // Box 2
                $box2 = Box::create([
                    'user_id' => $user->id,
                    'status' => 'open',
                    'start_date' => $start_date_2,
                ]);
                $meals2 = Meal::active()->whereHas('countries', function($e){
                    if(inAmerica()){
                        $e->where('code', 'usa');
                    }else{
                        $e->where('code', 'cad');
                    }
                })->inRandomOrder()
                    ->limit(3)
                    ->get();
                foreach ($meals2 as $m){
                    $m->inventory = $m->inventory - 1;
                    $m->save();
                    BoxItem::create([
                        'box_id' => $box2->id,
                        'itemable_type' => 'App\Meal',
                        'itemable_id' => $m->id
                    ]);
                }

                // Box 3
                $box3 = Box::create([
                    'user_id' => $user->id,
                    'status' => 'open',
                    'start_date' => $start_date_3,
                ]);
                $meals3 = Meal::active()->whereHas('countries', function($e){
                    if(inAmerica()){
                        $e->where('code', 'usa');
                    }else{
                        $e->where('code', 'cad');
                    }
                })->inRandomOrder()
                    ->limit(3)
                    ->get();
                foreach ($meals3 as $m){
                    $m->inventory = $m->inventory - 1;
                    $m->save();
                    BoxItem::create([
                        'box_id' => $box3->id,
                        'itemable_type' => 'App\Meal',
                        'itemable_id' => $m->id
                    ]);
                }

                // Box 4
                $box4 = Box::create([
                    'user_id' => $user->id,
                    'status' => 'open',
                    'start_date' => $start_date_4,
                ]);
                $meals4 = Meal::active()->whereHas('countries', function($e){
                    if(inAmerica()){
                        $e->where('code', 'usa');
                    }else{
                        $e->where('code', 'cad');
                    }
                })->inRandomOrder()
                    ->limit(3)
                    ->get();
                foreach ($meals4 as $m){
                    $m->inventory = $m->inventory - 1;
                    $m->save();
                    BoxItem::create([
                        'box_id' => $box4->id,
                        'itemable_type' => 'App\Meal',
                        'itemable_id' => $m->id
                    ]);
                }

                // Email the new user
                \Mail::to($user)->queue(new Welcome($user));

                // Login the new user
                Auth::login($user, true);

                DB::commit();

                flash()->overlay('You are all signed up! We look forward to cooking great tasting vegan meals with you!', 'Welcome to Vegano');

                return redirect()->route('home');
            } catch ( \Illuminate\Database\QueryException $exception ) {
                // You can check get the details of the error using `errorInfo`:
                $errorInfo = $exception->errorInfo;

                dd($exception->errorInfo);

                // Return the response to the client..
                flash()->overlay($errorInfo, 'ERROR: Failed to create meal.');

                return redirect()->back();
            }
        }
    }
