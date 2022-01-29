<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request){
        $user=$request->user();
        $products=Cart::with('product')
                         ->where('user_id',$user->id)
                         ->orWhere('id',$request->cookie('cart_id'))
                         ->get();

        if(! $products){
            return redirect()->back();
        }

        $total=$products->sum(function ($item){
              return $item->product->final_price * $item->quantity;
        });

        try{
            DB::beginTransaction();
           $order = $user->orders()->create([
                'total'=>$total
            ]);

            foreach ($products as $item){
              $order->items()->create([
                    'product_id'=>$item->product_id,
                    'quantity'=>$item->quantity,
                    'price'=>$item->product->final_price,
                ]);
            }

           Cart::where('user_id',$user->id)
                ->orWhere('id',$request->cookie('cart_id'))
                ->delete();
               DB::commit();
                event(new OrderCreated($order));
            return redirect()->route('orders')->with('success','Order Created');
        }catch(\Throwable $exception){
               DB::rollBack();
               return $exception;
            return redirect()->back()->with('error',$exception->getMessage());
        }



    }
}
