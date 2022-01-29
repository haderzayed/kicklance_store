<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('permission','roles')->exists();
    }

    public function view(User $user, Role $role)
    {
        return $user->role->permissions()->where('permission', 'roles')->exists();
    }

    public function create(User $user)
    {
        return $user->role->permissions()->where('permission', 'roles.create')->exists();
    }


    public function update(User $user, Role $role)
    {
        return $user->role->permissions()->where('permission', 'roles.update')->exists();
    }

    public function delete(User $user, Role $role)
    {
        return $user->role->permissions()->where('permission', 'roles.delete')->exists();
    }


    public function restore(User $user, Role $role)
    {
        //
    }


    public function forceDelete(User $user, Role $role)
    {
        //
    }
}
