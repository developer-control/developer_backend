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
}
