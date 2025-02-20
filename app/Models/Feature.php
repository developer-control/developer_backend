<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class);
    }
}
