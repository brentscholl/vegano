<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get all of the Product's BoxItems.
     * A Product can be many box items
     */
    public function boxItems()
    {
        return $this->morphMany('App\BoxItem', 'itemable');
    }

    /**
     * Get all of the Product's OrderItems.
     * A Product can be many order items
     */
    public function orderItems()
    {
        return $this->morphMany('App\OrderItem', 'itemable');
    }

    /**
     * Get the product's image.
     */
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    /**
     * The allergens that belong to the meal.
     */
    public function allergens()
    {
        return $this->belongsToMany('App\Allergen');
    }
}
