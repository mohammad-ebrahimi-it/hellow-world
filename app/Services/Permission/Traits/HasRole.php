<?php

namespace App\Services\Permission\Traits;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;

trait HasRole
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function giveRolesTo(...$roles)
    {
        $roles = $this->giveAllRoles($roles);

        if ($roles->isEmpty()) return $this;

        $this->roles()->syncWithoutDetaching($roles);
        return $this;
    }

    protected function giveAllRoles( array $roles)
    {
        return Role::whereIn('name', Arr::flatten($roles))->get();

    }

    public function withDrawRoles(...$roles)
    {
        $roles = $this->giveAllRoles($roles);

        $this->roles()->detach($roles);

        return $this;
    }

    public function refreshRoles(... $roles)
    {
        $roles = $this->giveAllRoles($roles);
        $this->roles()->sync($roles);
        return $this;
    }

    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }


}
