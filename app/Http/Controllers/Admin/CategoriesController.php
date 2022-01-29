<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Rules\ParentRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use voku\helper\ASCII;

class CategoriesController extends Controller
{
    public function validator($request,$id){
        $validators=validator::make($request->all(),[
            'name'=>['required','max:255','min:3',"unique:categories,name,$id"],
            'parent_id'=>['nullable',
                'exists:categories,id',
                new ParentRule($id)
                ],
            'descriptions'=>['nullable', 'max:1000']
        ]);
        return $validators;
    }

    public function index()
    {

        // $Products_number=$categories->products()->sum('quantity');
     /*  $categories=category::leftJoin('categories as parents','parents.id','=' ,'categories.parent_id')
                     ->leftJoin('products', 'products.category__id' , '=' , 'categories.id')
                     ->select([
                         'categories.id',
                         'categories.name',
                         'categories.parent_id',
                         'categories.created_at',
                         'categories.updated_at',
                         'parents.name as parent_name',
                         DB::raw('count(products.id) as products_count'),
                     ])
                      ->groupBy([
                          'categories.id',
                          'categories.name',
                          'categories.parent_id',
                          'categories.created_at',
                          'categories.updated_at',
                          'parent_name'
                      ])
                      ->orderBy('products_count','DESC')
                     ->paginate(); */
       /* if(!Gate::allows('categories')){
            abort(403,'you are not authorized');
        }
        if(Gate::denies('categories')){
            abort(403,'you are not authorized');
        }*/
        Gate::authorize('categories');
        $categories=category::with('parent')->withCount('products')
            ->orderBy('products_count','ASC')
            ->orderBy('name', )
            ->paginate();
        return view('admin.categories.index',compact('categories'));
    }


    public function show($id){
        $category=category::findOrFail($id);
        $products=$category->products;
        return  view('admin.categories.show',compact('category','products'));
    }

    public function create()
    {
      /*  if(Gate::denies('categories.create')){
            abort(403,'you are not authorized');
        }*/
        Gate::authorize('categories.create');
        $categories=category::all();
        return  view('admin.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function store(Request $request, $id='')
    {
        Gate::authorize('categories.store');
       $validators=$this->validator($request , $id);
        $validators->validate();


         category::create($request->all());
         return redirect()->route('categories.index')->with('success','Category Added Successfully');

    }

    public function edit($id)
    {
        Gate::authorize('categories.update');
        $category=category::findOrFail($id);
        $categories=category::where('id','<>',$id)
                     ->where('parent_id','<>',$id)
                     ->orWhereNull('parent_id')
                     ->get();
        return  view('admin.categories.edit',compact('categories','category'));

    }

    public function update(Request $request, $id)
    {
        Gate::authorize('categories.update');
        $validators=$this->validator($request,$id);
        $validators->validate();

        category::where('id',$id)->update([
            'name'=>$request['name'],
            'parent_id'=>$request['parent_id'],
            'description'=>$request['description'],
        ]);
        return redirect()->route('categories.index')->with('success','Category Updateded Successfully');
    }

     public function destroy($id)
    {
        Gate::authorize('categories.delete');
        category::findOrFail($id)->delete();
        return redirect()->route('categories.index')->with('success','Category Removed Successfully');
    }
    public function xml(){
        $categories=category::all();
        $xml='<?xml version="1.0" ?>';
        $xml .='<categories >';
        foreach ($categories as $category){
            $xml .=sprintf('<category id = "%d">',$category->id);
            $xml .=sprintf('<name> %s </name>',$category->name);
            $xml .='</category>';
        }
        $xml .='</categories >';
        return response($xml , 200 ,['Content-Type'=>'application/xml']);
    }

    public function json(){
        return category::all();
    }
}
