<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Get the owning imageable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
