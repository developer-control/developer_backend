<?php

namespace App\Traits;

use Spatie\Permission\Models\Permission;

trait HasOfficePermission
{
    public function hasOfficePermissionTo($permission)
    {
        // Jika user punya role superadmin, berikan semua akses
        if ($this->hasRole('superadmin')) {
            return true;
        }

        if (! $this->developer) return false;

        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }

        if (! $permission) return false;


        return $this->developer->hasPermissionTo($permission);
    }
}
