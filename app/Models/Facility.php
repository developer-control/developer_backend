<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
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
    public function media()
    {
        return $this->morphToMany(Media::class, 'sourceable', 'model_has_media')->withPivot('type');
    }
}
