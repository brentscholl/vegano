<?php

namespace App\Http\Controllers;

use App\User;
use App\UserShipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserShippingController extends Controller
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
        $shipping = UserShipping::where('user_id', Auth::user()->id)->firstOrFail();
        return view('user-dashboard.shipping-edit', compact('shipping'));
    }

    /**
     * Update the users shipping
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Rules
        $rules = [
            'shipping_address'     => 'required|string',
            'shipping_address_2'   => 'nullable|string',
            // 'shipping_country'     => 'required|string',
            // 'shipping_city'        => 'required|string',
            // 'shipping_state'       => 'required|string',
            'shipping_postal_code' => 'required|string',
            'delivery_instructions' => 'nullable|string',
        ];
        $this->validate(request(), $rules);

        try {
            DB::beginTransaction();
            $shipping = UserShipping::find(Auth::user()->user_shipping_id);
            $shipping->address_line_1 = $request->input('shipping_address');
            $shipping->address_line_2 = $request->input('shipping_address_2');
            $shipping->postal_code = $request->input('shipping_postal_code');
            $shipping->delivery_instructions = $request->input('delivery_instructions');
            $shipping->save();
            DB::commit();

            flash('Your shipping details have been updated')->success();

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
