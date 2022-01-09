<?php

use App\Http\Middleware\UserType;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('cart','CartController@index')->name('cart');
Route::post('cart','CartController@store')->name('cart.store');
Route::delete('cart','CartController@destroy')->name('cart.destroy');
Route::patch('cart','CartController@update')->name('cart.update');

Route::group(['namespace'=>'Admin','prefix'=>'Admin','middleware'=>['auth','verified','user.type:admin,user']],function (){
    ################################### categories ##############################################
    Route::group(['prefix'=>'categories'],function(){
        Route::get('index','CategoriesController@index')->name('categories.index');
        Route::get('show/{id}','CategoriesController@show')->name('categories.show');
        Route::get('create','CategoriesController@create')->name('categories.create');
        Route::post('store','CategoriesController@store')->name('categories.store');
        Route::get('edit/{id}','CategoriesController@edit')->name('categories.edit');
        Route::post('update/{id}','CategoriesController@update')->name('categories.update');
        Route::get('delete/{id}','CategoriesController@destroy')->name('categories.delete');
    });
    ################################### products ##############################################
    Route::group(['prefix'=>'products'],function(){
        Route::get('index','ProductsController@index')->name('products.index');
        Route::get('show/{id}','ProductsController@show')->name('products.show');
        Route::get('create','ProductsController@create')->name('products.create');
        Route::post('store','ProductsController@store')->name('products.store');
        Route::get('edit/{id}','ProductsController@edit')->name('products.edit');
        Route::post('update/{id}','ProductsController@update')->name('products.update');
        Route::get('delete/{id}','ProductsController@destroy')->name('products.delete');
    });
});


Route::get('/','IndexController@index' );

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('test',function(){
   $category = \App\Models\category::with('childs')->find(19);
 //  $category->load('childs');
   dd($category);
});
