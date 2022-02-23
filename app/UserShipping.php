<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserShipping extends Model
{
    use SoftDeletes;

    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get the user that owns the User Shipping
     */
    public function user()
    {
        return $this->belongsTo('App\User')->withTimestamps();// Model | foreign_key | local_key
    }
}
