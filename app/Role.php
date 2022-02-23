<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
