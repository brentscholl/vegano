<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * The users that belong to the role.
     */
    public function meals()
    {
        return $this->belongsToMany('App\Meal')->withTimestamps();
    }
}
