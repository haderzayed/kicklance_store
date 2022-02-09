<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function products(){
        return$this->hasManyThrough(
            product::class,
                User::class
        );
    }
}
