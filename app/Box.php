<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Box extends Model
{
    use SoftDeletes;

    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_date',
    ];

    /**
     * Eager loads
     * @var array
     */
    public $with = ['boxItems'];
    /**
     * Get the user that owns the box
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the box items for the box.
     */
    public function boxItems()
    {
        return $this->hasMany('App\BoxItem');
    }
}
