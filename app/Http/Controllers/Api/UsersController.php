<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
         return User::with('profile')->get();
    }


    public function store(Request $request)
    {
       $request->validate([
           'name'=>'required',
           'password'=>'required',
           'birthday'=>'required|date',
           'email'=>'required|email|unique:users'
       ]);
       DB::beginTransaction();
       try{
           $data=$request->only(['name','email','password']);
           $data['password']=Hash::make($request->post('password'));
           $user=User::create($data);
           $user->profile()->create($request->only(['birthday','gender','phone','address']));
           DB::commit();
           return [
               'code'=>1,
               'message'=>'User Added Successfully',
               'data'=>$user->load('profile'),
           ];
       }catch (\Exception $exception){
           DB::rollBack();
           return response()->json([
               'code'=>0,
               'message'=>$exception->getMessage(),
           ],500);
       }

    }


    public function show(User $user)
    {
         return $user->load('profile','products');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
