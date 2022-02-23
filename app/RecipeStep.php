<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeStep extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get the meal that owns the ingredient.
     */
    public function meal()
    {
        return $this->belongsTo('App\Meal');
    }
}
