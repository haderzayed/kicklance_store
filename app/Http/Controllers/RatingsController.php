<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
     public function storeProductRating(Request $request){

         $user=Auth::user();
         $request->validate([
             'product_id'=>'required|exists:products,id',
              'rating'=>'required|int|min:1|max:5'
         ]);
         $user->ratedProducts()->syncWithoutDetaching([
             $request->post( 'product_id')=>[
            'rating'=>$request->post( 'rating')
         ]
         ]);
         $product=product::findOrFail($request->post( 'product_id'));
         $sum=$product->ratings->sum(function ($item){
                   return $item->pivot->rating;
         });

         $avg=$sum / $product->ratings->count();
         $product->rating =$avg;
         $product->save();
          return [
            'rating'=>$avg
          ];
     }

    public function storeUserRating(Request $request){

        $user=Auth::user();
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'rating'=>'required|int|min:1|max:5'
        ]);
        $user->ratedUsers()->syncWithoutDetaching($request->post( 'user_id'),[
            'rating'=>$request->post( 'rating')
        ]);
        $ratedUsers=User::findOrFail($request->post( 'user_id'));
        $sum=$ratedUsers->ratings->sum(function ($item){
            return $item->pivot->rating;
        });
        $avg=$sum/$ratedUsers->ratings->count();
        return [
            'rating'=>$avg
        ];
    }
}
