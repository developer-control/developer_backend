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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function projectUnit()
    {
        return $this->belongsTo(ProjectUnit::class, 'project_unit_id');
    }
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
}
