<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index(){
        $user=Auth::user();
        $orders=$user->orders;
        return view('front.orders.index',compact('orders'));
    }

    public function show(Order $order){
      //  dd($order->products);
        if (Auth::id() != $order->user_id){
            abort(404);
        }
        return view('front.orders.show',compact('order'));
    }


}
