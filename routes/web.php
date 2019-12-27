<?php

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
//use App\Http\Resources\UsersResource as UserResource;
//use App\User;

Route::get('/user', function () {
    return new \App\Http\Resources\UsersResource(\App\User::find(1));
});
Route::get('/categories', function () {
    $user = \App\User::all();
    return $user;
});



Route::get('/', function () {
    return view('welcome');
});
