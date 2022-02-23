<?php

namespace App\Http\Controllers;

use App\Box;
use App\Coupon;
use App\Meal;
use App\Role;
use App\User;
use App\UserBilling;
use App\UserShipping;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->has('page') ? $request->input('page') : 1; // Use ?page=x if given, otherwise start at 1
        $numPerPage = 50; // Number of results per page

        //Remove search array
        session()->forget('SEARCH');

        $users = User::doesntHave('roles')->get();

        $count = $users->count(); // Get the total number of entries you'll be paging through

        $paginator = new Paginator($users, $count, $numPerPage, $page, [
            'path'  => $request->url(),
            'query' => $request->query(),
        ]);

        $page = 'users';

        return view('admin.users.users-index', compact('users', 'page', 'paginator'));
    }

    /**
     * Search Users
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function search(Request $request) {
        $page = $request->has('page') ? $request->input('page') : 1; // Use ?page=x if given, otherwise start at 1
        $numPerPage = 50; // Number of results per page

        // Reset search
        if ($request->has('reset')) {
            $request->session()->forget('SEARCH');

            return redirect()->route('admin.users.index');
        }

        // Start Search
        if ($request->get('search_by') != '') {
            session(['SEARCH.SEARCH_BY' => trim($request->get('search_by'))]);
        }

        if ($request->get('search_txt') != '') {
            session(['SEARCH.SEARCH_TXT' => trim($request->get('search_txt'))]);
        }

        if ($request->get('user_id') != '') {
            session(['SEARCH.USER_ID' => trim($request->get('user_id'))]);
        }

        if ($request->session()->get('SEARCH.SEARCH_BY') != '') {
            $userQuery = User::doesntHave('roles');
            if ($request->session()->get('SEARCH.SEARCH_BY') == 'id') {
                $userQuery->where('id', $request->session()->get('SEARCH.SEARCH_TXT'));
            }

            if ($request->session()->get('SEARCH.SEARCH_BY') == 'name') {
                $userQuery->where('first_name','LIKE', "%".$request->session()->get('SEARCH.SEARCH_TXT')."%")
                    ->orWhere('last_name','LIKE', "%".$request->session()->get('SEARCH.SEARCH_TXT')."%");
            }

            if ($request->session()->get('SEARCH.SEARCH_BY') == 'email') {
                $userQuery->where('email', $request->session()->get('SEARCH.SEARCH_TXT'));
            }

            $users = $userQuery->paginate($numPerPage);

            $count = $users->count();; // Get the total number of entries you'll be paging through

            $paginator = new Paginator($users, $count, $numPerPage, $page, [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]);

            $page = 'users';


            return view('admin.users.users-index', compact('users', 'page', 'paginator'));

        } else {
            flash('Search failed')->error();

            return redirect()->route('account.bookings');
        }
    }

    /**
     * Display a listing of admins
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $users = User::whereHas('roles', function($e){
            $e->where('role_id', 1);
        })->get();

        $page = "admin";

        return view('admin.users.admins-index', compact('users', 'page'));
    }

    /**
     * Show form to create admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createAdmin() {
        return view('admin.users.admins-create');
    }

    /**
     * Create the Admin
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeAdmin(Request $request) {
        // Rules
        $rules = [
            'first_name'           => 'required|string|min:2|max:12',
            'last_name'            => 'required|string|min:2|max:12',
            'email'                => 'required|string|email|max:255|unique:users,email',
            'password'             => 'required|string|min:6',
        ];
        $this->validate(request(), $rules);

        try {
            DB::beginTransaction();
            $user = User::create([
                'first_name'   => $request->input('first_name'),
                'last_name'    => $request->input('last_name'),
                'email'        => $request->input('email'),
                'password'     => Hash::make($request->input('password')),
            ]);
            $role = Role::find(1);
            $user->assignRole($role);
            DB::commit();

            flash('Admin Created')->success();

            return redirect()->route('admin.users.admins');
        } catch ( \Illuminate\Database\QueryException $exception ) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->errorInfo;

            dd($exception->errorInfo);

            // Return the response to the client..
            flash()->overlay($errorInfo, 'ERROR: Failed to create meal.');

            return redirect()->back();
        }
    }

    /**
     * Show the users account page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function account() {
        $user = Auth::user();
        $shipping = UserShipping::where('user_id', $user->id)->firstOrFail();
        $billing = UserBilling::where('user_id', $user->id)->firstOrFail();
        return view('user-dashboard.account', compact('user', 'shipping', 'billing'));
    }

    /**
     * Show the User edit form page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit() {
        return view('user-dashboard.user-edit');
    }

    /**
     * Show the user edit form on the admin dashboard
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminEdit($id) {
        $user = User::find($id);

        return view('admin.users.users-edit', compact('user'));
    }

    /**
     * Show the admin edit form on the dashboard
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminEditAdmin($id) {
        $user = User::find($id);

        return view('admin.users.admins-edit', compact('user'));
    }

    /**
     * Update the user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request) {
        // Rules
        $rules = [
            'first_name'           => 'required|string|min:2|max:12',
            'last_name'            => 'required|string|min:2|max:12',
            'email'                => 'required|string|email|max:255|unique:users,email,'.Auth::user()->id.',id,deleted_at,NULL',
            'phone_number'         => 'required|min:10|max:20|unique:users,phone_number,'.Auth::user()->id.',id,deleted_at,NULL',
        ];
        $this->validate(request(), $rules);

        try {
            DB::beginTransaction();
            $user = User::find(Auth::user()->id);
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->phone_number = $request->input('phone_number');
            $user->save();
            DB::commit();

            flash('Your account has been updated')->success();

            return redirect()->route('user.account');
        } catch ( \Illuminate\Database\QueryException $exception ) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->errorInfo;

            dd($exception->errorInfo);

            // Return the response to the client..
            flash()->overlay($errorInfo, 'ERROR: Failed to create meal.');

            return redirect()->back();
        }
    }

    /**
     * Update a user from the admin dashboard
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function adminUpdate(Request $request, $id) {
        // Rules
        $rules = [
            'first_name'           => 'required|string|min:2|max:12',
            'last_name'            => 'required|string|min:2|max:12',
            'email'                => 'required|string|email|max:255|unique:users,email,'.$id.',id,deleted_at,NULL',
            'phone_number'         => 'required|min:10|max:20|unique:users,phone_number,'.$id.',id,deleted_at,NULL',

            'shipping_address'     => 'required|string',
            'shipping_address_2'   => 'nullable|string',
            'shipping_country'     => 'required|string',
            'shipping_city'        => 'required|string',
            'shipping_state'       => 'required|string',
            'shipping_postal_code' => 'required|string',
            'delivery_instructions' => 'nullable|string',

            'billing_address'     => 'required|string',
            'billing_address_2'   => 'nullable|string',
            'billing_country'     => 'required|string',
            'billing_city'        => 'required|string',
            'billing_state'       => 'required|string',
            'billing_postal_code' => 'required|string',
        ];
        $this->validate(request(), $rules);

        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->phone_number = $request->input('phone_number');
            $user->save();

            $shipping = UserShipping::find($user->user_shipping_id);
            $shipping->address_line_1 = $request->input('shipping_address');
            $shipping->address_line_2 = $request->input('shipping_address_2');
            $shipping->postal_code = $request->input('shipping_postal_code');
            $shipping->delivery_instructions = $request->input('delivery_instructions');
            $shipping->save();

            $billing = UserBilling::find($user->user_billing_id);
            $billing->address_line_1 = $request->input('billing_address');
            $billing->address_line_2 = $request->input('billing_address_2');
            $billing->country = $request->input('billing_country');
            $billing->city = $request->input('billing_city');
            $billing->state = $request->input('billing_state');
            $billing->postal_code = $request->input('billing_postal_code');
            $billing->save();
            DB::commit();

            flash('User has been updated')->success();

            return redirect()->route('admin.users.index');
        } catch ( \Illuminate\Database\QueryException $exception ) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->errorInfo;

            dd($exception->errorInfo);

            // Return the response to the client..
            flash()->overlay($errorInfo, 'ERROR: Failed to create meal.');

            return redirect()->back();
        }
    }

    /**
     * Update an admin from the admin dashboard
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function adminUpdateAdmin(Request $request, $id) {
        // Rules
        $rules = [
            'first_name'           => 'required|string|min:2|max:12',
            'last_name'            => 'required|string|min:2|max:12',
            'email'                => 'required|string|email|max:255|unique:users,email,'.$id.',id,deleted_at,NULL',
            'password'             => 'nullable',
        ];
        $this->validate(request(), $rules);

        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            if($request->input('password')){
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();
            DB::commit();

            flash('Admin has been updated')->success();

            return redirect()->route('admin.users.admins');
        } catch ( \Illuminate\Database\QueryException $exception ) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->errorInfo;

            dd($exception->errorInfo);

            // Return the response to the client..
            flash()->overlay($errorInfo, 'ERROR: Failed to create meal.');

            return redirect()->back();
        }
    }
    /**
     * Unsubscribe the User
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe($id)
    {

        $box_dates_start = Carbon::parse('next Sunday')->addWeeks(1)->toDateString();
        $boxes = Box::with('boxItems')
            ->where('user_id', Auth::user()->id)
            ->where('start_date', '>=', $box_dates_start)
            ->get();

        // Skip their boxes
        foreach($boxes as $box){
            $box->status = 'skipped';
            $box->save();
        }

        Auth::user()->subscription('standard')->cancel();

        flash()->overlay('You will no longer be able to receive meals at the end of your current paid week.', 'Your subscription has been canceled');

        return redirect()->back();
    }

    /**
     * Resubscribe the User
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resubscribe($id)
    {

        if(! Auth::user()->subscribed('standard')){
            Auth::user()->subscription('standard')->resume();
        }

        flash()->overlay('We are glad to see you back. Enjoy!', 'Your subscription has been resumed');

        return redirect()->back();
    }

    /**
     * Apply a coupon to the users account
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function applyCoupon(Request $request) {
        // Rules
        $rules = [
            'coupon_code'           => 'required|string|min:9|max:10|exists:coupons,token',
        ];
        $this->validate(request(), $rules);

        try {
            DB::beginTransaction();

            // Get the coupon
            $coupon = Coupon::where('token', $request->input('coupon_code'))->first();

            // If a coupon exists
            if($coupon){

                $user = Auth::user();
                $weeks = $coupon->amount;

                if($user->paid_subscription_start_date){// if the user is already on a coupon, then we just add to it
                    $date = Carbon::parse($user->paid_subscription_start_date)->addWeeks($weeks)->toDateString();
                    $user->paid_subscription_start_date = $date;
                }else{
                    $paid_sub_start_date = Carbon::parse('next thursday')->addWeeks($weeks)->toDateString();
                    $user->paid_subscription_start_date = $paid_sub_start_date;
                }
                $user->save();
                $coupon->delete();
            }else{
                flash('Coupon Invalid')->error();
                return redirect()->back();
            }
            DB::commit();

            flash()->overlay($weeks . ' free weeks have been added to your subscription. Enjoy!', 'Coupon Applied');

            return redirect()->back();
        } catch ( \Illuminate\Database\QueryException $exception ) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->errorInfo;

            dd($exception->errorInfo);

            // Return the response to the client..
            flash()->overlay($errorInfo, 'ERROR: Failed to create meal.');

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     * todo: fix delete logic because user is deleted before box is sent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $password = $request->input('password');
        DB::beginTransaction();
        $user = User::find(Auth::user()->id);
        if (! app('hash')->check($password, $user->password)) {
            flash()->overlay('Your account was not deleted. Please Try again.', 'Password Incorrect.');
            return redirect()->back();
        }

        $date = Carbon::parse('next sunday')->addDay(1)->toDateString();

        $boxes = Box::with('boxItems')
            ->where('user_id', Auth::user()->id)
            ->where('start_date', '>', $date)
            ->get();

        // Skip their boxes
        foreach($boxes as $box){
            $box->status = 'skipped';
            $box->save();
        }

        $user->subscription('standard')->cancel();

        // Should not delete the user until after their final box has been sent? Need to fix this

        // $userShipping = UserShipping::find($user->user_shipping_id);
        // $userShipping->delete();
        //
        // $userBilling = UserBilling::find($user->user_billing_id);
        // $userBilling->delete();

        $user->delete();

        DB::commit();

        flash()->overlay('Sorry to see you go! Your account has been removed. Your final delivery will be sent.', 'Your account has been deleted');

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminDestroy(Request $request)
    {
        return true;
    }

    /**
     * Deleted an admin from the admin dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function adminDestroyAdmin(Request $request, $id)
    {
        DB::beginTransaction();
        $user = User::find($id);

        if(!$user->isAdmin()){
            flash('Can not delete user. User is not admin')->error();
            return redirect()->back();
        }

        $role = Role::find(1);
        $user->roles()->detach($role);

        $user->delete();
        DB::commit();

        flash('Admin Deleted')->success();

        return redirect()->route('admin.users.admins');
    }
}
