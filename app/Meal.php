<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Meal extends Model
{
    use SoftDeletes;
    use HasSlug;

    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * Eager loads
     * @var array
     */
    public $with = ['image'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the meal's image.
     */
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    /**
     * Get all of the Meal's BoxItems.
     * A meal can be many box items
     */
    public function boxItems()
    {
        return $this->morphMany('App\BoxItem', 'itemable');
    }

    /**
     * Get all of the Meal's OrderItems.
     * A meal can be many order items
     */
    public function orderItems()
    {
        return $this->morphMany('App\OrderItem', 'itemable');
    }

    /**
     * The allergens that belong to the meal.
     */
    public function allergens()
    {
        return $this->belongsToMany('App\Allergen');
    }

    /**
     * The tools that belong to the meal.
     */
    public function tools()
    {
        return $this->belongsToMany('App\Tool');
    }

    /**
     * The categories that belong to the meal.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /**
     * Get the chef that owns the meal.
     */
    public function chef()
    {
        return $this->belongsTo('App\Chef');
    }



    /**
     * Get the ingredients for the meal.
     */
    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient')->withPivot('measurement')->withTimestamps();
    }

    /**
     * Get the recipe steps for the meal.
     */
    public function recipeSteps()
    {
        return $this->hasMany('App\RecipeStep');
    }

    /**
     * Get the reviews for the meal.
     */
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    /**
     * The country that belong to the meal.
     */
    public function countries()
    {
        return $this->belongsToMany('App\Country')->withTimestamps();
    }

    /**
     * Checks if meal is in a country
     *
     * @param $name
     * @return bool
     */
    public function inCountry($name)
    {
        foreach ($this->countries as $country) {
            if ($country->country == $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if meal is Canada
     *
     * @return bool
     */
    public function inCanada()
    {
        foreach ($this->countries as $country) {
            if ($country->code == 'cad') {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if meal is United States
     *
     * @return bool
     */
    public function isUSA()
    {
        foreach ($this->countries as $country) {
            if ($country->code == 'usa') {
                return true;
            }
        }

        return false;
    }

    /**
     * Assign a role to a user
     *
     * @param $country
     * @return mixed
     */
    public function assignCountry($country)
    {
        return $this->countries()->attach($country);
    }

    /**
     * Gets meals that are published, has inventory, is within start and end date
     */
    public function scopeActive($query) {
        return $query->with(['image'])->where('published', 1)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->where('inventory', '>', 0);
    }
}
