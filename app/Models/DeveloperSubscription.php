<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeveloperSubscription extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }
}
