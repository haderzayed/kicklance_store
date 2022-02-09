<?php

namespace App\Http\Controllers;

use App\Models\product;

use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $products=product::with('category')
            ->featured()
            ->popular(90,90)
            ->latest()->take(6)->get();
      //  return $users=User::get();
        return view('front.home',compact('products'));
    }
}
