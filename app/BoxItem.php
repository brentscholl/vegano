<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoxItem extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Eager loads
     * @var array
     */
    public $with = ['itemable'];

    /**
     * Get the box that owns the box item.
     */
    public function box()
    {
        return $this->belongsTo('App\Box');
    }

    /**
     * Get the owning itemable model.
     */
    public function itemable()
    {
        return $this->morphTo();
    }
}
