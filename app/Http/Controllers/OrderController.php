<?php

namespace App\Http\Controllers;

use App\Box;
use App\BoxItem;
use App\Mail\BoxDelivered;
use App\Mail\BoxShipped;
use App\Meal;
use App\User;
use App\UserShipping;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $page = $request->has('page') ? $request->input('page') : 1; // Use ?page=x if given, otherwise start at 1
        $numPerPage = 50; // Number of results per page

        session()->forget('SEARCH');


        // Reset search
        if ( $request->has('reset') ) {
            $request->session()->forget('SEARCH');

            return redirect()->route('admin.boxes.index');
        }

        // Start Search
        if ( $request->get('search_by') != '' ) {
            session(['SEARCH.SEARCH_BY' => trim($request->get('search_by'))]);
        }

        if ( $request->get('search_txt') != '' ) {
            session(['SEARCH.SEARCH_TXT' => trim($request->get('search_txt'))]);
        }

        if ( $request->get('meal_id') != '' ) {
            session(['SEARCH.MEAL_ID' => trim($request->get('meal_id'))]);
        }

        if ( $request->get('user_id') != '' ) {
            session(['SEARCH.USER_ID' => trim($request->get('user_id'))]);
        }

        if ( $request->session()->get('SEARCH.SEARCH_BY') != '' ) {
            $mealQuery = Box::whereHas('user', function ($e) use ($request) {
                $e->whereHas('shipping', function ($u) use ($request) {
                    if ( $request->query('country') == 'cad' ) {
                        $u->where('country', 'Canada');
                    } elseif ( $request->query('country') == 'usa' ) {
                        $u->where('country', 'United States');
                    }
                })->where('status', 'ordered')->orWhere('status', 'completed');
            });

            if ( $request->session()->get('SEARCH.SEARCH_BY') == 'id' ) {
                $mealQuery->where('id', $request->session()->get('SEARCH.SEARCH_TXT'));
            }

            if ( $request->session()->get('SEARCH.SEARCH_BY') == 'meal' ) {
                $mealQuery->whereHas('boxItems', function ($e) use ($request) {
                    $e->where('itemable_type', 'App\Meal')->where('itemable_id', $request->session()->get('SEARCH.MEAL_ID'));
                });
            }

            if ( $request->session()->get('SEARCH.SEARCH_BY') == 'user_id' ) {
                $mealQuery->where('user_id', $request->session()->get('SEARCH.SEARCH_TXT'));
            }

// Get the order status selected
            $query = request('order_status');

            if ( $query ) {
                $orders = $mealQuery->where('status', 'ordered')->where('order_status', $query)->orderBy('start_date', 'desc')->paginate($numPerPage);
                $allBoxes = $orders;
            } else {
                $orders = $mealQuery->where('status', 'ordered')->orderBy('start_date', 'desc')->paginate($numPerPage);
                $allBoxes = Box::all();
            }

            $count = $orders->total();; // Get the total number of entries you'll be paging through

            $paginator = new Paginator($orders, $count, $numPerPage, $page, [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]);

            $query = null;
            $mealList = ['' => 'Select Meal'] + Meal::pluck('title', 'id')->all();

            return view('admin.orders.orders-index', compact('orders', 'query', 'allBoxes', 'mealList', 'paginator'));
        } else {
            //Remove search array
            session()->forget('SEARCH');

            $box = Box::whereHas('user', function ($e) use ($request) {
                $e->whereHas('shipping', function ($u) use ($request) {
                    if ( $request->query('country') == 'cad' ) {
                        $u->where('country', 'Canada');
                    } elseif ( $request->query('country') == 'usa' ) {
                        $u->where('country', 'United States');
                    }
                });
            });

            // Get the order status selected
            $query = request('order_status');

            if ( $query ) {
                $orders = $box->where('status', 'ordered')->where('order_status', $query)->orderBy('start_date', 'desc')->paginate($numPerPage);
            } else {
                $orders = $box->where('status', 'ordered')->orderBy('start_date', 'desc')->paginate($numPerPage);
            }

            $allBoxes = Box::all();

            $mealList = ['' => 'Select Meal'] + Meal::pluck('title', 'id')->all();

            $count = $orders->total(); // Get the total number of entries you'll be paging through

            $paginator = new Paginator($orders, $count, $numPerPage, $page, [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]);

            return view('admin.orders.orders-index', compact('orders', 'query', 'allBoxes', 'mealList', 'paginator'));
        }
    }

    /**
     * Search Boxes
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $page = $request->has('page') ? $request->input('page') : 1; // Use ?page=x if given, otherwise start at 1
        $numPerPage = 50; // Number of results per page

        // Reset search
        if ($request->has('reset')) {
            $request->session()->forget('SEARCH');

            return redirect()->route('admin.boxes.index');
        }

        // Start Search
        if ($request->get('search_by') != '') {
            session(['SEARCH.SEARCH_BY' => trim($request->get('search_by'))]);
        }

        if ($request->get('search_txt') != '') {
            session(['SEARCH.SEARCH_TXT' => trim($request->get('search_txt'))]);
        }

        if ($request->get('meal_id') != '') {
            session(['SEARCH.MEAL_ID' => trim($request->get('meal_id'))]);
        }

        if ($request->get('user_id') != '') {
            session(['SEARCH.USER_ID' => trim($request->get('user_id'))]);
        }

        if ($request->session()->get('SEARCH.SEARCH_BY') != '') {
            $mealQuery = Box::whereHas('user', function($e) use($request) {
                $e->whereHas('shipping', function($u) use ($request){
                    if($request->query('country') == 'cad') {
                        $u->where('country', 'Canada');
                    }elseif($request->query('country') == 'usa'){
                        $u->where('country', 'United States');
                    }
                })->where('status', 'ordered')->orWhere('status', 'completed');
            });

            if ($request->session()->get('SEARCH.SEARCH_BY') == 'id') {
                $mealQuery->where('id', $request->session()->get('SEARCH.SEARCH_TXT'));
            }

            if ($request->session()->get('SEARCH.SEARCH_BY') == 'meal') {
                $mealQuery->whereHas('boxItems', function ($e) use ($request) {
                    $e->where('itemable_type', 'App\Meal')->where('itemable_id', $request->session()->get('SEARCH.MEAL_ID'));
                });
            }

            if ($request->session()->get('SEARCH.SEARCH_BY') == 'user_id') {
                $mealQuery->where('user_id', $request->session()->get('SEARCH.SEARCH_TXT'));
            }

// Get the order status selected
            $query = request('order_status');

            if($query){
                $orders = $mealQuery->where('status', 'ordered')->where('order_status', $query)->orderBy('start_date', 'desc')->paginate($numPerPage);
                $allBoxes = $orders;
            }else{
                $orders = $mealQuery->where('status', 'ordered')->orderBy('start_date', 'desc')->paginate($numPerPage);
                $allBoxes = Box::all();
            }

            $count = $orders->total();; // Get the total number of entries you'll be paging through

            $paginator = new Paginator($orders, $count, $numPerPage, $page, [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]);

            $query = null;
            $mealList = ['' => 'Select Meal'] + Meal::pluck('title', 'id')->all();

            return view('admin.orders.orders-index', compact('orders', 'query', 'allBoxes', 'mealList', 'paginator'));

        } else {
            //Remove search array
            session()->forget('SEARCH');

            $box = Box::whereHas('user', function($e) use($request) {
                $e->whereHas('shipping', function($u) use ($request){
                    if($request->query('country') == 'cad') {
                        $u->where('country', 'Canada');
                    }elseif($request->query('country') == 'usa'){
                        $u->where('country', 'United States');
                    }
                });
            });

            // Get the order status selected
            $query = request('order_status');

            if($query){
                $orders = $box->where('status', 'ordered')->where('order_status', $query)->orderBy('start_date', 'desc')->paginate($numPerPage);
            }else{
                $orders = $box->where('status', 'ordered')->orderBy('start_date', 'desc')->paginate($numPerPage);
            }

            $allBoxes = Box::all();

            $mealList = ['' => 'Select Meal'] + Meal::pluck('title', 'id')->all();

            $count = $orders->total(); // Get the total number of entries you'll be paging through

            $paginator = new Paginator($orders, $count, $numPerPage, $page, [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]);

            return view('admin.orders.orders-index', compact('orders', 'query', 'allBoxes', 'mealList', 'paginator'));
        }
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
        $order = Box::with('boxItems')->find($id);
        $shipping = UserShipping::where('user_id',$order->user_id)->first();

        return view('admin.orders.orders-show', compact('order', 'shipping'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function prep(Request $request)
    {
        $meals = BoxItem::with('box')
            ->whereHas('box', function($e) use ($request){
                $e->whereHas('user', function($u) use($request) {
                    $u->whereHas('shipping', function ($s) use ($request) {
                        if ( $request->query('country') == 'cad' ) {
                            $s->where('country', 'Canada');
                        } elseif ( $request->query('country') == 'usa' ) {
                            $s->where('country', 'United States');
                        }
                        });
                    })
                    ->where('status', 'ordered')
                    ->where('order_status', 'pending')
                    ->orWhere('order_status', 'in-prep');
            })->get()->groupBy('itemable_id');


        return view('admin.orders.prep-station', compact('meals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $order = Box::find($id);
        if ( $request->input('order_status') == 'delivered' ) {
            // Email the order user
            \Mail::to($order->user)->queue(new BoxDelivered($order->user));
            $order->status = 'completed';
        }else {
            $order->status = 'ordered';
        }
        if( $request->input('order_status') == 'shipped' ){
            // Email the order user
            \Mail::to($order->user)->queue(new BoxShipped($order->user));
        }
        $order->order_status = $request->input('order_status');
        $order->save();

        flash('Order Updated')->success();
        return redirect()->back();
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
