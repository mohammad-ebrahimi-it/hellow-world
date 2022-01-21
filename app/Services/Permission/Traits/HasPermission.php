<?php

namespace App\Services\Permission\Traits;

use App\Models\Permission;
use Illuminate\Support\Arr;

trait HasPermission
{
    public function permission()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions->isEmpty()) return $this;

        $this->permission()->syncWithoutDetaching($permissions);
        return $this;
    }

    protected function getAllPermissions(array $permission)
    {
        return Permission::whereIn('name', Arr::flatten($permission))->get();
    }

    public function withDrawPermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permission()->detach([$permissions]);
        return $this;
    }

    public function refreshPermission(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permission()->sync($permissions);
        return $this;

    }

    public function hasPermission(Permission $permission)
    {
        return $this->hasPermissionsThroughRole($permission)
            || $this->permission->contains($permission);

    }

    protected function hasPermissionsThroughRole(Permission $permission)
    {
        foreach ($permission->roles() as $role) {
            if ($this->roles->contains($role)) return true;
        }
        return false;
    }


}
