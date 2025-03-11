<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }
    public function developerSubscriptions()
    {
        return $this->hasMany(DeveloperSubscription::class, 'subscription_id');
    }
    public function developers()
    {
        return $this->belongsToMany(
            Subscription::class,
            'developer_subscriptions',
            'subscription_id', // Foreign key di tabel pivot yang mengacu ke Subscription
            'developer_id', // Foreign key di tabel pivot yang mengacu ke Developer
        );
    }
}
