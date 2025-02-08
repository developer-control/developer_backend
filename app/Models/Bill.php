<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'usage_period_at' => 'date',
        'billed_at' => 'date',
    ];
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
    public function billType()
    {
        return $this->belongsTo(BillType::class, 'bill_type_id');
    }
    public function projectUnit()
    {
        return $this->belongsTo(ProjectUnit::class, 'project_unit_id');
    }
    public function payments()
    {
        return $this->belongsToMany(Payment::class);
    }
}
