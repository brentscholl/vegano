<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get the user that submitted the order.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }
}
