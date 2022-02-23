<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * The meals that belong to the category
     */
    public function meals()
    {
        return $this->belongsToMany('App\Meal')->withTimestamps();
    }
}
