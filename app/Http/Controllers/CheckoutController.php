<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use Symfony\Component\HttpKernel\Exception\HttpException;


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

          /* Cart::where('user_id',$user->id)
                ->orWhere('id',$request->cookie('cart_id'))
                ->delete();*/
               DB::commit();
             //   event(new OrderCreated($order));
          //  $user->notify(new OrderCreatedNotification($order));
            $users=User::whereIn('type',['super_admin','admin'])->get();
            Notification::send( $users , new OrderCreatedNotification($order));

            return redirect()->route('orders')->with('success','Order Created');
        }catch(\Throwable $exception){
               DB::rollBack();

            return redirect()->back()->with('error',$exception->getMessage());
        }

    }

  /*  public function createOrder(){

        $client=$this->getPaypalClient();
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "test_ref_id1",
                "amount" => [
                    "value" => "100.00",
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                "cancel_url" =>  URL::route('paypal.cancel'),
                "return_url" =>  URL::route('paypal.return')
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
              if($response->statusCode == 201){
                  session()->put('paypal_order_id',$response->result->id);
                  foreach ($response->result->links as $link){
                      if($link->rel == 'approve'){
                           return redirect()->away($link->href);
                      }
                  }

              }

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
          dd($response);
        }catch (HttpException $ex) {
           // echo $ex->statusCode;
            print_r($ex->getMessage());
        }

    }

    public function paypalReturn(){
      //  dd(request()->all(),session()->get('paypal_order_id'));
        $request = new OrdersCaptureRequest(session()->get('paypal_order_id'));
        $request->prefer('return=representation');

        try {
           $client=$this->getPaypalClient();
            $response = $client->execute($request);
            session()->forget('paypal_order_id');
             dd($response);
        }catch (HttpException $ex) {
           // echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }
    public function paypalCancel(){
        dd(request()->all());

    }
    protected function getPaypalClient(){
        $paypalConfig=config('services.paypal');
        $clientId = $paypalConfig['client_id'];
        $clientSecret = $paypalConfig['secret'];

        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);

        return $client;
    }*/
}
