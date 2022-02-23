<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Display the home page
     *
     * @return \Illuminate\Http\Response
     */
    public function homeLogic($city = '')
    {
        if(inAmerica()){
            $countryCode = 'usa';
        }else{
            $countryCode = 'cad';
        }

        if(Auth::user()){
            // Logged in
            $sliderMeals = Meal::active()->whereHas('countries', function($e) use($countryCode) {
                $e->where('code', $countryCode);
            })->inRandomOrder()->take(4);
            $meals = Meal::active()->whereHas('countries', function($e) use($countryCode) {
                $e->where('code', $countryCode);
            })->inRandomOrder()->get();

            return view('home', compact('meals'));

        }else{
            // Not logged in
            $sliderMeals = Meal::active()->whereHas('countries', function($e) use($countryCode) {
                $e->where('code', $countryCode);
            })->inRandomOrder()->take(4)->get();
            $featuredMeals = Meal::active()->whereHas('countries', function($e) use($countryCode) {
                $e->where('code', $countryCode);
            })->inRandomOrder()->get();

            return view('welcome', compact('featuredMeals', 'sliderMeals', 'city'));

        }
    }

    /**
     * Display The home page
     * @return \Illuminate\Http\Response
     */
    public function home() {
        return $this->homeLogic();
    }

    /**
     * Display the menu page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menu() {
        if(inAmerica()){
            $countryCode = 'usa';
        }else{
            $countryCode = 'cad';
        }

        $meals = Meal::active()->whereHas('countries', function($e) use($countryCode) {
            $e->where('code', $countryCode);
        })->get();

        return view('meals.meals-index', compact('meals'));
    }

    /**
     * Show Contact Us page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact() {
        return view('contact-us');
    }

    /**
     * Submit the contact form
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function contactSubmit(Request $request) {
        $rules = [
            'name'  => 'required|string|min:2|max:12',
            'email' => 'required|string|email|max:255',
        ];

        $this->validate(request(), $rules);

        try {
            // Send email
            $contact = [];
            $contact['name'] = $request->input('name');
            $contact['email'] = $request->input('email');
            $contact['message'] = $request->input('message');

            $to = [
                [
                    'email' => 'veganofoodsinc@gmail.com',
                    'name' => 'Vegano Contact Form',
                ],
            ];

            \Mail::to($to)->queue(new Contact($contact));

            flash()->overlay('We will respond to you shortly. Thank you!', 'Message Sent!');

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
     * Show Terms of service page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms() {
        return view('terms');
    }

    /**
     * Show Privacy Policy
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privacy() {
        return view('privacy-policy');
    }


    // CITY PAGES ==================================================================================
    /**
     * Show Vancouver Page
     * @return \Illuminate\Http\Response
     */
    public function cityVancouver()
    {
        return $this->homeLogic('Vancouver');
    }

    /**
     * Show Los Angeles Page
     * @return \Illuminate\Http\Response
     */
    public function cityLosAngeles()
    {
        return $this->homeLogic('Los Angeles');
    }
}
