<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function items(){

        return $this->hasMany(OrderProduct::class,'order_id','id');
    }
    public function products(){

        return $this->belongsToMany(product::class,'order_products')
                     ->using(OrderProduct::class)
                     ->withPivot([
                         'price','quantity'
                     ]);
    }

   /* public function getRouteKeyName()
    {
        return 'slug';
    }*/

   /* protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->slug = Str::slug($order->title);
        });
    }*/



}
