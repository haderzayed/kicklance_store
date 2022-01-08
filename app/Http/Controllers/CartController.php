<?php



namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function Livewire\str;

class CartController extends Controller
{
    public function index(){
        $cart=Cart::where('id',$this->getCartId())
             ->orWhere('user_id',Auth::id())
             ->get();
        $sub_total=$cart->sum(function ($item){
         return $item->quantity * $item->product->price;
        });
        $tax_ratio=14;
        $tax=$sub_total * $tax_ratio/100;
        $total=$sub_total+$tax;
        return view('front.cart',compact('cart','sub_total','tax','total'));
    }

    public  function store(Request $request){
    //    dd($request);
           $request->validate([
               'product_id'=>['required','exists:products,id'],
               'quantity'=>['int','min:1'],
           ]);

           $cart=Cart::where([    'id'=>$this->getCartId(),
               'product_id'=>$request->post('product_id'),
               ])->first();
           /*  $cart=Cart::where([
               'id'=>$this->getCartId(),
               'product_id'=>$request->post('product_id'),
               ])->first();

           if($cart){

              Cart::where([
                   'id'=>$this->getCartId(),
                   'product_id'=>$request->post('product_id'),
               ])->update([
                   'quantity'=>  $cart->quantity + $request->post('quantity',1)
              ]);

           }else{
               $cart=Cart::create([
                   'id'=>$this->getCartId(),
                   'product_id'=>$request->post('product_id'),
                   'quantity'=> $request->post('quantity',1),
                   'user_id'=>Auth::id(),
               ] );
           }*/
           $cart=Cart::updateOrCreate([
               'id'=>$this->getCartId(),
               'product_id'=>$request->post('product_id'),
           ],[

               'quantity'=>DB::raw('quantity + ' . $request->post('quantity',1)),
               'user_id'=>Auth::id(),
           ] );
           //$product=product::find($request-
          $name=$cart->product->name;
           return redirect()->back()->with('success'," Product $name added to cart");
    }
    public function getCartId(){
        $id= request()->cookie('cart_id');
        if(!$id){
            $id=str::uuid();
            Cookie::queue('cart_id',$id,60 *24 *7);
        }
        return $id;
    }
}
