<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use voku\helper\ASCII;

class CategoriesController extends Controller
{
    public function validator($request){
        $validators=validator::make($request->all(),[
            'name'=>'required|max:255,min:3',
            'parent_id'=>'nullable|exists:categories,id',
            'descriptions'=>'nullable|max:1000'
        ]);
        return $validators;
    }

    public function index()
    {
        $categories=category::all();
        return view('categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categories=category::all();
        return  view('categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function store(Request $request)
    {
       $validators=$this->validator($request);
        $validators->validate();

         category::create([
             'name'=>$request['name'],
             'parent_id'=>$request['parent_id'],
             'description'=>$request['description'],
         ]);
         return redirect()->route('categories.index');
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
        $categories=category::all();
        $category=category::findOrFail($id);
        return  view('categories.edit',compact('categories','category'));

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
        $validators=$this->validator($request);
        $validators->validate();
        
        category::where('id',$id)->update([
            'name'=>$request['name'],
            'parent_id'=>$request['parent_id'],
            'description'=>$request['description'],
        ]);
        return redirect()->route('categories.index');
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
        return redirect()->route('categories.index');
    }
}
