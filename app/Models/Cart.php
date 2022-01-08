<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    public $incrementing=false;
    public $timestamps=false;
    protected $keyType='string';

    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
 //using in case I use composite primary key
    protected function setKeysForSaveQuery($query){
        $query->where([
                'id'=>$this->attributes['id'],
                'product_id'=>$this->attributes['product_id'],
              ]);
        return $query;
    }


}
