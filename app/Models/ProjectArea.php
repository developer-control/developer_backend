<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectArea extends Model
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
}
