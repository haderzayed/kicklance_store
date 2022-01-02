<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Rules\ParentRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
       $categories=category::all();
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
                     ->paginate();*/
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
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
       $validators=$this->validator($request , $id);
        $validators->validate();

         category::create([
             'name'=>$request['name'],
             'parent_id'=>$request['parent_id'],
             'description'=>$request['description'],
         ]);
         return redirect()->route('categories.index')->with('success','Category Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=category::findOrFail($id);
        $categories=category::where('id','<>',$id)
                     ->where('parent_id','<>',$id)
                     ->orWhereNull('parent_id')
                     ->get();
        return  view('admin.categories.edit',compact('categories','category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validators=$this->validator($request,$id);
        $validators->validate();

        category::where('id',$id)->update([
            'name'=>$request['name'],
            'parent_id'=>$request['parent_id'],
            'description'=>$request['description'],
        ]);
        return redirect()->route('categories.index')->with('success','Category Updateded Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      category::findOrFail($id)->delete();
        return redirect()->route('categories.index')->with('success','Category Removed Successfully');
    }
}
