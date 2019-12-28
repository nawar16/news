<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\Api\UserController as UserController;
use App\User;

/**
     * user related
 */
Route::get('/authors', 'Api\UserController@index');
Route::get('/authors/{id}', 'Api\UserController@show');
Route::get('/posts/authors/{id}', 'Api\UserController@posts');
Route::get('/comments/authors/{id}', 'Api\UserController@comments');
///////////end user related///////////

/**
     * post related
 */
Route::get('/categories', 'Api\CategoryController@index');
Route::get('/posts/categories/{id}', 'Api\CategoryController@posts');
Route::get('/posts', 'Api\PostController@index');
Route::get('/posts/{id}', 'Api\PostController@show');
Route::get('comments/posts/{id}', 'Api\PostController@comments');
///////////end post related///////////

Route::post('/register', 'Api\UserController@store');
Route::post('/token', 'Api\UserController@getToken');


Route::middleware('auth:api')->group(function () {
    Route::post('update-user/{id}', 'Api\UserController@update');
    Route::post('/postss', 'Api\PostController@store');
    Route::post('/postss/{id}', 'Api\PostController@update');
    Route::delete('/postss/{id}', 'Api\PostController@destroy');
});

//Route::middleware('auth:api')->get('/user', 'UserController@AuthRouteAPI');
