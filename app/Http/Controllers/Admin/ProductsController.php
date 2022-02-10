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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
   public function index(){
      // Gate::authorize('products');
       $this->authorize('viewAny',product::class);
        $categories=category::all();
       $request=request();
       $filters=$request->query();
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
           })
            ->withDraft()
        //  ->withoutGlobalScope('published')
          // ->onlyTrashed();
         // ->withTrashed()
       ;
       return view('admin.products.index',[
           'categories'=>$categories,
           'products'=>$products->paginate(),
           'filters'=>$filters,
           ]);
   }


   public function show($id){
       $product=product::withDraft()->with('tags')->findOrFail($id);
       $this->authorize('view',$product);
       $tags=Tag::whereRaw('id In (SELECT tag_id FROM product_tag WHERE product_id = ?)',$id)->get();
       return view('admin.products.show',compact('product','tags'));
   }


   public function create(){
       $this->authorize('create',product::class);
       $categories=category::all();
       $tags=Tag::all();
       return view('admin.products.create',compact('categories','tags'));
   }

   public function store(Request $request){
       //Gate::authorize('products.store');
       $this->authorize('create',product::class);
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
       //Gate::authorize('products.update');
       $product=product::withDraft()->findOrFail($id);
       $categories=category::all();
       $tags=Tag::all();
    //   $this->authorize('update',$product);
       $product_tag=implode(',',$product->tags()->pluck('name')->toArray());
       return view('admin.products.edit',compact('categories','product','tags','product_tag'));
   }

   public function update(Request $request ,$id){
    //   Gate::authorize('products.update');
       $product=product::withDraft()->findOrFail($id);
       $this->authorize('update',$product);
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
       $product->update($data);
       $this->saveTags($product, $request);
       //$tags=$request->post('tag',[]);
      // $product->tags()->sync($tags);
      // $product->tags()->syncWithoutDetaching($tags);

       if(isset($old_image) && isset($data['image'])){
           Storage::disk('public')->delete($old_image);
       }
       return redirect()->route('products.index')->with('success',"product updated successfully ");
   }

   public function destroy($id){
     //  Gate::authorize('products.delete');
       $product=product::withDraft()->findOrFail($id);
       $this->authorize('delete',$product);
       $product->delete();

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

   public function trash(){
       $products=product::with('category')->withDraft()->onlyTrashed()->paginate();
       return view('admin.products.trash',compact('products'));
   }
   public function restore(Request $request,$id){
       $product=product::onlyTrashed()->findOrFail($id);
       $product->restore();
       return redirect()->route('products.index')->with('success',"product Deleted restored ");

   }

   public function forceDelete($id){
       $product=product::onlyTrashed()->withDraft()->findOrFail($id);
       $product->forceDelete();
        /* if($product->image){
          Storage::disk('public')->delete($product->image);
      }*/
       return redirect()->route('products.index')->with('success',"product Deleted force deleted ");
   }
}
