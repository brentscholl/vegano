<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    /**
     * Get the owning itemable model.
     */
    public function itemable()
    {
        return $this->morphTo();
    }
}
