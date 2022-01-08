<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $products=product::latest()->take(6)->get();
        return view('front.home',compact('products'));
    }
}
