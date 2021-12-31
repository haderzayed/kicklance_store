<?php

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

Route::group(['namespace'=>'Admin','prefix'=>'Admin'],function (){
    Route::group(['prefix'=>'categories'],function(){
        Route::get('index','CategoriesController@index')->name('categories.index');
        Route::get('create','CategoriesController@create')->name('categories.create');
        Route::post('store','CategoriesController@store')->name('categories.store');
        Route::get('edit/{id}','CategoriesController@edit')->name('categories.edit');
        Route::post('update/{id}','CategoriesController@update')->name('categories.update');
        Route::get('delete/{id}','CategoriesController@destroy')->name('categories.delete');
    });
});


Route::get('/', function () {
    return 'hello';
});
