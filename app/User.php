<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;
    use SoftDeletes;


    // Add fields you want to protect from mass assignment
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'ends_at',
        'trial_ends_at',
        'paid_subscription_start_date',
    ];

    /**
     * Eager loads
     * @var array
     */
    public $with = ['roles'];

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role')->withTimestamps();
    }

    /**
     * Checks if user is subscribed to a role
     *
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if user is an admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        foreach ($this->roles as $role) {
            if ($role->name == 'admin') {
                return true;
            }
        }

        return false;
    }

    /**
     * Assign a role to a user
     *
     * @param $role
     * @return mixed
     */
    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    /**
     * Get the user shipping record associated with the user.
     */
    public function shipping()
    {
        return $this->hasOne('App\UserShipping');// Model | foreign_key | local_key
    }

    /**
     * Get the user billing record associated with the user.
     */
    public function billing()
    {
        return $this->hasOne('App\UserBilling');// Model | foreign_key | local_key
    }

    /**
     * Get the user settings record associated with the user.
     */
    public function settings()
    {
        return $this->hasOne('App\UserSettings', 'user_settings_id');// Model | foreign_key | local_key
    }

    /**
     * Get the box record associated with the user.
     */
    public function boxes()
    {
        return $this->hasMany('App\Box');// Model | foreign_key | local_key
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * Get the reviews by th user.
     */
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    /**
     * Get all of the subscriptions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function subscriptions()
    {
        return $this->hasMany(\App\Subscription::class, $this->getForeignKey())->orderBy('created_at', 'desc');
    }
}
