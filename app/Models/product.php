<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function category(){

      return  $this->belongsTo(category::class,'category__id');
    }
    public function user(){
        return   $this->belongsTo(User::class,'user_id')->withDefault([
            'name'=>' '
        ]);
    }
    public function tags(){
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',

        );
    }

    public function getImageUrlAttribute()
    {
        return ($this->image !== null) ? asset('storage/'.$this->image) : asset('images/default.jpg');

    }
}
