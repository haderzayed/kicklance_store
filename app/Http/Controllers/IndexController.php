<?php

namespace App\Http\Controllers;

use App\Models\product;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index(){
        $products=product::with('category')
           // ->featured()
           // ->popular(90,90)
            ->withCount([
                'favouriteUsers as favourite'=> function($query){
                $query->where('id','=',Auth::id());
                }
           ])
            ->latest()->limit(6)->get();
      //  return $users=User::get();
        return view('front.home',compact('products'));
    }
}
