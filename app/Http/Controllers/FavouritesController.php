<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouritesController extends Controller
{




    public function store(Request $request)
    {
        $user=Auth::user();
        $request->validate([
            'product_id'=>'required|exists:products,id'
        ]);

        $user->favouriteProducts()->syncWithoutDetaching($request->post('product_id'));
        return[
          'message'=>'product added to your favourite',
        ];
    }





    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $user=Auth::user();
        $user->favouriteProducts()->detach($id);
        return[
            'message'=>'product deleted from your favourite',
        ];
    }
}
