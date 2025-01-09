<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
    public function projectAreas()
    {
        return $this->hasMany(ProjectArea::class, 'project_id');
    }
}
