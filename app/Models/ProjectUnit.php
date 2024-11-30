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
}
