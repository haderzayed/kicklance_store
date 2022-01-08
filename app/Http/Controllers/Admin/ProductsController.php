<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
       $products=product::with('category','user')->when($request->query('name'),function ($query,$name){
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


   public function show($id){
       $product=product::with('tags')->findOrFail($id);
       $tags=Tag::whereRaw('id In (SELECT tag_id FROM product_tag WHERE product_id = ?)',$id)->get();
       return view('admin.products.show',compact('product','tags'));
   }


   public function create(){
       $categories=category::all();
       $tags=Tag::all();
       return view('admin.products.create',compact('categories','tags'));
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

       $data=$request->except('image', 'tags');
       $image=$request->file('image');
       if($request->hasFile('image') && $image->isValid()){
           $data['image']=$image->store('products','public');
       }
       $data['user_id']=Auth::id();        //Auth::user()->id // $request()->user()->id;
       $product= product::create($data);
       $this->saveTags($product, $request);
      // $tags=$request->post('tag',[]);
       //$product->tags()->sync($tags);
       return redirect()->route('products.index')->with('success',"product $product->name created successfully ");
   }

   public function edit($id){
       $categories=category::all();
       $product=product::findOrFail($id);
       $tags=Tag::all();
       //$product_tag=$product->tags()->pluck('id')->toArray();
       $product_tag=implode(',',$product->tags()->pluck('name')->toArray());
//       $s=Storage::disk('public');
//       dd($s,$product->image);
       return view('admin.products.edit',compact('categories','product','tags','product_tag'));
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
       $data=$request->except('image','_token','tags');
       $image=$request->file('image');
       if($request->hasFile('image') && $image->isValid()){
           $data['image']=$image->store('products','public');
       }
      // $product=product::where('id',$id)->update($data);
       $product->update($data);
       $this->saveTags($product, $request);
       //$tags=$request->post('tag',[]);
      // $product->tags()->sync($tags);
      // $product->tags()->syncWithoutDetaching($tags);

       /*DB::table('product_tag')->where('product_id',$id)->delete();
       foreach ($tags as $tag_id){
          DB::table('product_tag')->insert([
              'product_id'=>$id,
              'tag_id'=>$tag_id
          ]);
       }*/
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

   public function saveTags(product $product,Request $request){

      $tags=explode(',',$request->post('tags'));
      $tags_id=[];
      foreach ($tags as $name){
          $name=strtolower(trim($name));
          $tag=Tag::where('name',$name)->first();
          if(!$tag){
              $tag=Tag::create([
                  'name'=>$name
              ]);
          }
          $tags_id[]=$tag->id;
      }
       $product->tags()->sync($tags_id);
   }
}
