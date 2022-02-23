<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get the meal that owns the ingredient.
     */
    public function meals()
    {
        return $this->belongsToMany('App\Meal')->withPivot('measurement')->withTimestamps();
    }
}
