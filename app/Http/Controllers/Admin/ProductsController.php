<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
   public function index(){
       $products=product::all();
       return view('admin.products.index',compact('products'));
   }
   public function create(){
       $categories=category::all();
       return view('admin.products.create',compact('categories'));
   }

   public function store(Request $request){

      $data= $request->validate([
          'name'=>'required',
          'category__id'=>'required|exists:categories,id',
          'price'=>'required|numeric',
          'sale_price'=>'nullable|numeric',
          'quantity'=>'int',
          'description'=>'nullable',
          'image'=>'mimes:jpg,jpeg,png',
      ]);

       $data=$request->except('image');
       $image=$request->file('image');
       if($request->hasFile('image') && $image->isValid()){
           $data['image']=$image->store('products','public');
       }
      $product= product::create($data);
       return redirect()->route('products.index')->with('success',"product $product->name created successfully ");
   }

   public function edit($id){
       $categories=category::all();
       $product=product::findOrFail($id);
//       $s=Storage::disk('public');
//       dd($s,$product->image);
       return view('admin.products.edit',compact('categories','product'));
   }

   public function update(Request $request ,$id){
       $product=product::findOrFail($id);
        $request->validate([
           'name'=>'required',
           'category__id'=>'required|exists:categories,id',
           'price'=>'required|numeric',
           'sale_price'=>'nullable|numeric',
           'quantity'=>'int',
           'description'=>'nullable',
           'image'=>'mimes:jpg,jpeg,png',
       ]);

       $old_image=$product->image;
     //  dd($old_image);
       $data=$request->except('image','_token');
       $image=$request->file('image');
       if($request->hasFile('image') && $image->isValid()){
           $data['image']=$image->store('products','public');
       }

       $product=product::where('id',$id)->update($data);
       if($old_image && isset($data['image'])){
           $img= Str::after($old_image,'//127.0.0.1:8000/');
          // Storage::disk('public')->delete($old_image);
           //dd($old_image,$img);
           unlink($img);
       }
       return redirect()->route('products.index')->with('success',"product updated successfully ");
   }
}
