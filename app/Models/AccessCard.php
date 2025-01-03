<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessCard extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }

    public function projectUnit()
    {
        return $this->belongsTo(ProjectUnit::class, 'project_unit_id');
    }
}
