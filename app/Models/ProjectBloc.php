<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectBloc extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
    public function projectArea()
    {
        return $this->belongsTo(ProjectArea::class, 'project_area_id');
    }
}
