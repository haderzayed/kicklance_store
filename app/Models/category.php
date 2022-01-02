<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function parent(){
        return  $this->belongsTo(self::class,'parent_id')->withDefault([
            'name' => 'Parent'
        ]);
    }
    public function productCount(){
        return $this->hasMany(product::class,'category__id');
    }
}
