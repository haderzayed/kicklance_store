<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
  /* public function form(Order $order){

       return view('payment.form',compact('order'));
   }*/

   public function callback(Order $order){

       $id=request()->query('id');
       $token=base64_encode(config('services.moyasar.secret'). ':') ;
      $payment= Http::baseUrl('https://api.moyasar.com/v1')
           ->withBasicAuth(config('services.moyasar.secret'),'')
           ->get("payments/{$id}")
           ->json();

        if($payment['status']=='paid') {
            $order->status = 'paid';
            $order->save();
            $capture = Http::baseUrl('https://api.moyasar.com/v1')
                ->withHeaders([
                    'Authorization' => "Basic {$token}"
                ])
                ->post("payments/{$id}/capture")
                ->json();
            if (isset($payment['type']) && $payment['type'] == 'invalid_request_error') {
                return redirect()->route('order.show', $order->id)->with('error', $payment['message']);
            }
            if ($capture['status'] == 'captured') {
                $order->status = 'paid';
                $order->save();

            }
        }
       return redirect()->route('order.show',$order->id)->with('success', 'Order Paid');
   }
}
