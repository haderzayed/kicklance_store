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
        $categories=category::all();
       $request=request();
       $filters=$request->query();
       /*$products=product::query();
       if($request->query('name')){
           $products->where('name','LiKe','%'. $request->query('name') .'%');
       }
       if($request->query('price_min')){
           $products->where('price','LiKe','%'. $request->query('price_min') .'%');
       }
       if($request->query('price_max')){
           $products->where('price','LiKe','%'. $request->query('price_max') .'%');
       }
       if($request->query('category_id')){
           $products->where('category__id','LiKe','%'. $request->query('category_id') .'%');
       }*/
    /*   $products=product::when($value,function ($query->object of database,$value){
           $query->where('name','LiKe','%'. $value .'%');
       });*/
       // Eager loading
       $products=product::with('category')->when($request->query('name'),function ($query,$name){
           $query->where('name','LIKE','%'. $name .'%');
       })
          ->when($request->query('price_min'),function ($query,$price_min){
              $query->where('price','>=', $price_min );
          })
           ->when($request->query('price_max'),function ($query,$price_max){
               $query->where('price','<=', $price_max );
           })
           ->when($request->query('category_id'),function ($query,$category_id){
               $query->where('category__id','=', $category_id );
           });
       return view('admin.products.index',[
           'categories'=>$categories,
           'products'=>$products->paginate(),
           'filters'=>$filters,
           ]);
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
       $data=$request->except('image','_token');
       $image=$request->file('image');
       if($request->hasFile('image') && $image->isValid()){
           $data['image']=$image->store('products','public');
       }
       $product=product::where('id',$id)->update($data);
       if(isset($old_image) && isset($data['image'])){
         /*  $img= Str::after($old_image,'/storage');
           $img=base_path('storage/app/public'.$img);
           unlink($img);*/
           Storage::disk('public')->delete($old_image);
       }
       return redirect()->route('products.index')->with('success',"product updated successfully ");
   }

   public function destroy($id){
       $product=product::findOrFail($id);
       $product->delete();
       if($product->image){
           Storage::disk('public')->delete($product->image);
       }
       return redirect()->route('products.index')->with('success',"product Deleted successfully ");
   }

}
