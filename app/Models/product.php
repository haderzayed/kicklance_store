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
    public function orders(){

        return $this->belongsToMany(Order::class,'order_products')
            ->using(OrderProduct::class)
            ->using(OrderProduct::class)
            ->withPivot([
                'price','quantity'
            ]);
    }
    public function getFinalPriceAttribute(){
        if($this->sale_price > 0){
            return $this->sale_price;
        }
        return $this->price;
    }

    public function getImageUrlAttribute()
    {
        return ($this->image !== null) ? asset('storage/'.$this->image) : asset('images/default.jpg');

    }
}
