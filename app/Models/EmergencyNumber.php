<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyNumber extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
