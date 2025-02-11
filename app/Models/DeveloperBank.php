<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeveloperBank extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function media()
    {
        return $this->morphToMany(Media::class, 'sourceable', 'model_has_media')->withPivot('type');
    }
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
}
