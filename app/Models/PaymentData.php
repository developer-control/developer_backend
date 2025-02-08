<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentData extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function developerBank()
    {
        return $this->belongsTo(DeveloperBank::class, 'developer_bank_id');
    }
}
