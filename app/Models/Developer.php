<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Developer extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function developerSubscriptions()
    {
        return $this->hasMany(DeveloperSubscription::class, 'developer_id');
    }
}
