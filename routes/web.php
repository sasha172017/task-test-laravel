<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAuth;
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

Route::post('/currency', "CurrenciesController@create")->middleware(CheckAuth::class);
Route::put('/currency/{id}', "CurrenciesController@update")->middleware(CheckAuth::class);
Route::delete('/currency/{id}', "CurrenciesController@delete")->middleware(CheckAuth::class);
Route::get('/currencies', "CurrenciesController@index");
Route::get('/currency/{id}', "CurrenciesController@show");
Route::get('/history', "CurrenciesController@history");
Route::post('authentication', 'UserController@authentication');
Route::get('/', function (){
    return view('index');
});
