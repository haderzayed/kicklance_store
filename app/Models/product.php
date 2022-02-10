<?php

namespace App\Models;

use App\Observers\ProductObserver;
use App\Scopes\PublishedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=[];

    //global scope modal
   protected static function booted(){
       static::addGlobalScope(new PublishedScope());
       static::observe(ProductObserver::class);
    }
    //local scope modal

    public function scopeFeatured(Builder $builder){
        $builder->where('featured','1');
    }

    public function scopeWithDraft(Builder $builder){
        $builder->withoutGlobalScope( PublishedScope::class);
    }
    public function scopePopular(Builder $builder ,$views , $sales=0){
          $builder->where('views','>',$views);
          if($sales){
              $builder->where('sales','>',$sales);
          }
    }
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
    public function ratings(){
        return $this->morphMany(Rating::class ,'rateable');
    }
    public  function favouriteUsers(){

        return $this->belongsToMany(User::class,'favourites');
    }

}
