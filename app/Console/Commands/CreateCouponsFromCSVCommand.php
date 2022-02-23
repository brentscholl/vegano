<?php

namespace App\Console\Commands;

use App\Coupon;
use Illuminate\Console\Command;
use Dirape\Token\Token;

class CreateCouponsFromCSVCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vegano:create-coupons-from-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Coupons from CSV ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Convert CSV to Array
        $filename= asset("/admin/vegano-orders.csv");
        $delimiter = ",";
        $header = null;
        $data = array();
        if (($handle = fopen($filename, "r")) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        $ar = $data;

        // Adjust the array to combine the matching rows

        //ordernumber, first name, last name, email, product name and quantity
        $temp = array();
        $prev_array = array();
        $order_number = "";
        foreach ($ar as $key => $value){
            if(empty($order_number)){
                $order_number = $value['Order #'];
                $temp[] = array(
                    "Order #" => $value["Order #"],
                    "Shipping First Name" => $ar[$key]["Shipping First Name"],
                    "Shipping Last Name" => $ar[$key]["Shipping Last Name"],
                    "Shipping Email" => $ar[$key]["Shipping Email"],
                );
                $prev_array = $value;
            }else if ($prev_array["Order #"] == $value['Order #']){
                $prev_array = array_merge($prev_array,array(
                    "Product Name" =>$value["Product Name"],
                    "Product Quantity" => $value["Product Quantity"]
                ));
                array_push($temp,$prev_array);
            }else if ($order_number != $value['Order #']){
                $temp[] = array(
                    "Order #" => $value['Order #'],
                    "Shipping First Name" => $value["Shipping First Name"],
                    "Shipping Last Name" => $value["Shipping Last Name"],
                    "Shipping Email" => $value["Shipping Email"],
                );
                $prev_array = $value;
            }
        }
        $final_array = array();

        // Create the Final Formatted array
        foreach ($temp as $key => $value){
            if(count($value) == 4){
                continue;
            }
            $final_array[] = array(
                "Order #" => $value["Order #"],
                "Shipping First Name" => $value["Shipping First Name"],
                "Shipping Last Name" => $value["Shipping Last Name"],
                "Shipping Email" => $value["Shipping Email"],
                "Product Name" =>$value["Product Name"],
                "Product Quantity" => $value["Product Quantity"]
            );
        }

        // Create the Coupon for each item in array
        foreach($final_array as $c){
            if($c['Order #']){ // Some array items are empty so check
                // Figure out how many weeks they bought
                $numberOfWeeks = 0;
                switch($c['Product Name']){
                    case "Three Month Subscription":
                        $numberOfWeeks = 12;
                        break;
                    case "Two Month Subscription":
                        $numberOfWeeks = 8;
                        break;
                    case "One Month Starter Kit":
                        $numberOfWeeks = 4;
                        break;
                    case "Vegano 2 Week Promo Card":
                        $numberOfWeeks = 2;
                        break;
                }

                // Create the Coupon
                Coupon::create([
                    'token' => (new Token())->UniqueNumber('coupons', 'token', 9),
                    'amount' => $numberOfWeeks,
                    'type' => 'early-bird',
                    'email' => $c["Shipping Email"],
                    'first_name' => $c["Shipping First Name"],
                    'last_name' => $c["Shipping Last Name"],
                    'sent' => '0',
                ]);
            }
        }
    }
}
