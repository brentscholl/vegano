<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get the meal that owns the review.
     */
    public function meal()
    {
        return $this->belongsTo('App\Meal');
    }

    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
