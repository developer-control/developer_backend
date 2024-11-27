<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
}
