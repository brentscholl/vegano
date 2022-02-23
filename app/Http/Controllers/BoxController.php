<?php

namespace App\Http\Controllers;

use App\Box;
use App\BoxItem;
use App\Meal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
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
     * Show the user their boxes
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boxes = Box::where('user_id', Auth::user()->id)->get();

        return view('user-dashboard.my-box', compact('boxes'));
    }

    /**
     * Replace a meal in one of the user's box
     * @param $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\RedirectResponse
     */
    public function replace($id, Request $request) {
        // Get the box item to replace
        $boxItem = BoxItem::find($id);

        // Check if this user owns this box item
        if($boxItem->box->user_id != Auth::user()->id){

            // Return the response to the client..
            flash('ERROR: You do not own this resource.')->error();

            return redirect()->back();
        }

        // Add 1 to inventory of this box item meal because we are not removing it from a box
        $boxItem->itemable->inventory = $boxItem->itemable->inventory + 1;
        $boxItem->itemable->save();

        // Get the new meal id for the box item
        $boxItem->itemable_id = $request->input('meal_id');
        $boxItem->save();

        // Remove 1 from the inventory because we are now adding it to a box
        $boxItem->itemable->inventory = $boxItem->itemable->inventory - 1;
        $boxItem->itemable->save();

        // Return their updated set of boxes
        $box_dates_start = Carbon::parse('next Sunday')->addWeeks(-1)->toDateString();

        return Box::with('boxItems')
            ->where('user_id', Auth::user()->id)
            ->where('start_date', '>=', $box_dates_start)
            ->get();
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
     * Skip this box
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function skip(Request $request, $id)
    {
        // Get the box to skip
        $box = Box::find($id);

        // Check that the auth user owns this box
        if($box->user_id != Auth::user()->id){

            // Return the response to the client..
            flash('ERROR: You do not own this resource.')->error();

            return redirect()->back();
        }

        // Start updating the box
        DB::beginTransaction();

        // Remove each box item.
        foreach($box->boxItems as $boxItem){
            // Item is being removed from box so we add 1 to meal inventory
            $boxItem->itemable->inventory = $boxItem->itemable->inventory + 1;
            $boxItem->itemable->save();

            // Delete the box item
            $boxItem->delete();
        }

        // Update box status
        $box->status = 'skipped';
        $box->save();

        DB::commit();

        // Return their update set of boxes
        $box_dates_start = Carbon::parse('next Sunday')->addWeeks(-1)->toDateString();

        return Box::with('boxItems')
            ->where('user_id', Auth::user()->id)
            ->where('start_date', '>=', $box_dates_start)
            ->get();
    }

    /**
     * UnSkip this box
     *
     * todo:: Finish this logic
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unskip(Request $request, $id)
    {
        // Get the box to skip
        $box = Box::find($id);

        // Check that the auth user owns this box
        if($box->user_id != Auth::user()->id){

            // Return the response to the client..
            flash('ERROR: You do not own this resource.')->error();

            return redirect()->back();
        }

        // Start updating the box
        DB::beginTransaction();

        $allowedDate = Carbon::parse('next thursday')->toDateString();

        if($box->start_date > $allowedDate){

            $meals = Meal::active()->whereHas('countries', function($e){
                if(inAmerica()){
                    $e->where('code', 'usa');
                }else{
                    $e->where('code', 'cad');
                }
            })->inRandomOrder()
                ->limit(3)
                ->get();

            foreach ($meals as $m){
                $m->inventory = $m->inventory - 1;
                $m->save();
                BoxItem::create([
                    'box_id' => $box->id,
                    'itemable_type' => 'App\Meal',
                    'itemable_id' => $m->id
                ]);
            }

            // Update box status
            $box->status = 'open';
            $box->save();
        }

        DB::commit();

        // Return their update set of boxes
        $box_dates_start = Carbon::parse('next Sunday')->addWeeks(-1)->toDateString();

        return Box::with('boxItems')
            ->where('user_id', Auth::user()->id)
            ->where('start_date', '>=', $box_dates_start)
            ->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Only admins should be able to delete boxes
        if(Auth::user()->isAdmin()){
            $box = Box::find($id);
            $box->delete();

            flash('Box Deleted');
            return redirect()->back();
        }

        flash('Not Allowed to delete box')->error();
        return redirect()->back();
    }
}
