<?php
// Common function used throughout the app

    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;

    /**
     *  Get the users location
     * @return \Torann\GeoIP\GeoIP|\Torann\GeoIP\Location
     */
    function getUserLocation(){
        return geoip(request()->ip());
    }

    /**
     * Check if user is in Canada
     * @return bool
     */
    function inCanada(){
        if(getUserLocation()->iso_code == "CA"){
            return true;
        }
        return false;
    }

    /**
     *  Check if user is in America
     * @return bool
     */
    function inAmerica(){
        if(getUserLocation()->iso_code == "US"){
            return true;
        }
        return false;
    }

    /**
     * Figure out when the users subscription renews
     * @param $plan
     * @return string
     */
    function getSubscriptionRenewDate($plan) {
        $sub = Auth::user()->subscription($plan)->asStripeSubscription();
        return Carbon::createFromTimeStamp($sub->current_period_end)->format('F jS, Y');
    }

    /**
     * Orientate an image, based on its exif rotation state
     *
     * @param Intervention\Image\Image $image
     * @param integer $orientation Image exif orientation
     * @return Intervention\Image\Image
     */
    function orientate($image, $orientation)
    {
        switch ($orientation) {

            // 888888
            // 88
            // 8888
            // 88
            // 88
            case 1:
                return $image;

            // 888888
            //     88
            //   8888
            //     88
            //     88
            case 2:
                return $image->flip('h');


            //     88
            //     88
            //   8888
            //     88
            // 888888
            case 3:
                return $image->rotate(180);

            // 88
            // 88
            // 8888
            // 88
            // 888888
            case 4:
                return $image->rotate(180)->flip('h');

            // 8888888888
            // 88  88
            // 88
            case 5:
                return $image->rotate(-90)->flip('h');

            // 88
            // 88  88
            // 8888888888
            case 6:
                return $image->rotate(-90);

            //         88
            //     88  88
            // 8888888888
            case 7:
                return $image->rotate(-90)->flip('v');

            // 8888888888
            //     88  88
            //         88
            case 8:
                return $image->rotate(90);

            default:
                return $image;
        }
    }

