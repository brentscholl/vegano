<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBilling extends Model
{
    use SoftDeletes;

    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get the user that owns the User Billing
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_billing_id')->withTimestamps();// Model | foreign_key | local_key
    }
}
