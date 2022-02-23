<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get the user that owns the User Settings
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_settings_id')->withTimestamps();// Model | foreign_key | local_key
    }
}
