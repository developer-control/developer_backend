<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectUnit extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
    public function projectBloc()
    {
        return $this->belongsTo(ProjectBloc::class, 'project_bloc_id');
    }
    public function userUnits()
    {
        return $this->hasMany(UserUnit::class, 'project_unit_id');
    }
    public function unitActive()
    {
        return $this->hasOne(UserUnit::class, 'project_unit_id')->where('is_active', 1)->where('status', 'claimed');
    }

    public function renovationPermits()
    {
        return $this->hasMany(RenovationPermit::class, 'project_unit_id');
    }
}
