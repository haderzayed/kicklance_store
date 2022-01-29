<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role->permissions()->where('permission','products')->exists();
    }

    public function view(User $user, Product $product)
    {
        if($user->id != $product->user_id){
            return false;
        }
        return $user->role->permissions()->where('permission','products')->exists();
    }

    public function create(User $user)
    {
        return $user->role->permissions()->where('permission','products.create')->exists();
    }

    public function update(User $user, Product $product)
    {
        if($user->id != $product->user_id){
            return false;
        }
        return $user->role->permissions()->where('permission','products.update')->exists();
    }

    public function delete(User $user, Product $product)
    {
        if($user->id != $product->user_id){
            return false;
        }
        return $user->role->permissions()->where('permission','products.delete')->exists();
    }


    public function restore(User $user, Product $product)
    {

    }


    public function forceDelete(User $user, Product $product)
    {

    }

}
