<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * The meals that belong to the tool
     */
    public function meals()
    {
        return $this->belongsToMany('App\Meal')->withTimestamps();
    }
}
