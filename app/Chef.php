<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get the meals for the chef.
     */
    public function meals()
    {
        return $this->hasMany('App\Meal');
    }

    /**
     * Get the chef's image.
     */
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }
}
