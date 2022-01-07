<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products (){
        return $this->hasMany(product::class,'category__id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('name','desc');
    }


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->withDefault([
            'name' => 'Parent'
        ]);
    }



}
