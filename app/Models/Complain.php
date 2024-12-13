<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complain extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $casts = [
        'solved_at' => 'datetime'
    ];
    /**
     * Interact with the user's first name.
     */
    protected function type(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => $value ? strtolower($value) : null,
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
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
    public function projectUnit()
    {
        return $this->belongsTo(ProjectUnit::class, 'project_unit_id');
    }
    public function solvedBy()
    {
        return $this->belongsTo(User::class, 'solved_by');
    }
}
