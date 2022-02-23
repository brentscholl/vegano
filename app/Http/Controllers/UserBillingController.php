<?php

namespace App\Http\Controllers;

use App\UserBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserBillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $billing = UserBilling::where('user_id', Auth::user()->id)->firstOrFail();
        return view('user-dashboard.billing-edit', compact('billing'));
    }

    /**
     * Update the users billing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Rules
        $rules = [
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
            $billing = UserBilling::find(Auth::user()->user_billing_id);
            $billing->address_line_1 = $request->input('billing_address');
            $billing->address_line_2 = $request->input('billing_address_2');
            $billing->country = $request->input('billing_country');
            $billing->city = $request->input('billing_city');
            $billing->state = $request->input('billing_state');
            $billing->postal_code = $request->input('billing_postal_code');
            $billing->save();
            DB::commit();

            flash('Your billing details have been updated')->success();

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
     * Show credit card edit page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function creditcardEdit() {
        $user = Auth::user();
        $intent = $user->createSetupIntent();
        return view('user-dashboard.creditcard-edit', compact('intent'));
    }

    /**
     * Update the users credit card
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function creditcardUpdate(Request $request) {
        try {
            $paymentMethod = $request->input('stripeToken');
            Auth::user()->updateDefaultPaymentMethod($paymentMethod);
            Auth::user()->updateDefaultPaymentMethodFromStripe();

            flash('Your billing details have been updated')->success();

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
