<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable=['name'];

    public function permissions()
    {
        return $this->hasMany(RolePermission::class,'role_id');
    }

    public function users(){
        return $this->hasMany(User::class,'role_id');
    }
}
