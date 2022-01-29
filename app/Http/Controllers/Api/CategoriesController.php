<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index()
    {
       return category::paginate();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);
        $category=category::create($request->all());
        return [
            'code'=>1,
            'status'=>'success',
            'message'=>'category created successfully',
            'data'=>$category,
        ];
    }

    public function show($id)
    {
        return category::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $category=category::findOrFail($id);
        $request->validate([
            'name'=>'required'
        ]);
        $category->update($request->all());
        return [
            'code'=>1,
            'status'=>'success',
            'message'=>'category updated successfully',
            'data'=>$category,
        ];
    }


    public function destroy($id)
    {
        $category=category::findOrFail($id);
        $category->delete();
        return [
            'code'=>1,
            'status'=>'success',
            'message'=>'category deleted successfully',
        ];
    }
}
