<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function bills()
    {
        return $this->belongsToMany(Bill::class);
    }
    public function paymentData()
    {
        return $this->hasOne(PaymentData::class);
    }
}
