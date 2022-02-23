<?php

namespace App;

    use Laravel\Cashier\Subscription as CashierSubscription;
    use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends CashierSubscription
{
    use SoftDeletes;

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
    ];
}
