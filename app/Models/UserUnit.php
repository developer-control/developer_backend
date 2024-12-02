<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserUnit extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function projectArea()
    {
        return $this->belongsTo(ProjectArea::class, 'project_area_id');
    }
    public function projectBloc()
    {
        return $this->belongsTo(ProjectBloc::class, 'project_bloc_id');
    }
    public function projectUnit()
    {
        return $this->belongsTo(ProjectUnit::class, 'project_unit_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function ownershipUnit()
    {
        return $this->belongsTo(OwnershipUnit::class, 'ownership_unit_id');
    }
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    public function media()
    {
        return $this->morphToMany(Media::class, 'sourceable', 'model_has_media')->withPivot('type');
    }
}
