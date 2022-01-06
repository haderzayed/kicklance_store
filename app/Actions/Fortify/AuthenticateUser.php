<?php

namespace App\Actions\Fortify;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateUser{

    public function authenticate(Request $request){
             $request->validate([
                 config('fortify.username')=>['required'],
                 'password'=>['required']
             ]);
              $username=$request->post('username');
              $password=$request->post('password');
              $user=User::where('username',$username)
                          ->orWhere('email',$username)
                          ->orWhere('phone',$username)
                         ->first();
              if($user && Hash::check($password,$user->password)){

                  return $user;
              }
    }
}
