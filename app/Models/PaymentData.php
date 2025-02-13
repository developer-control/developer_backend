<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentData extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'paid_at' => 'datetime'
    ];
    public function developerBank()
    {
        return $this->belongsTo(DeveloperBank::class, 'developer_bank_id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
    public function media()
    {
        return $this->morphToMany(Media::class, 'sourceable', 'model_has_media')->withPivot('type');
    }
}
