<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allergen extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * The meals that belong to the allergens
     */
    public function meals()
    {
        return $this->belongsToMany('App\Meal')->withTimestamps();
    }

    /**
     * The meals that belong to the allergens
     */
    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }
}
