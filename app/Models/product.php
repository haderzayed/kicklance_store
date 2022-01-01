<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function categories(){

      return  $this->belongsTo(category::class,'category__id');
    }

    public function getImageAttribute($val)
    {
        return ($val !== null) ? asset('storage/'.$val) : asset('images/default.jpg');

    }
}
