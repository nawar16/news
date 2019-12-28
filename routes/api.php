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
//use App\Http\Resources\UsersResource as UserResource;
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
///////////end post related///////////


/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::middleware('auth:api')->get('/user', 'UserController@AuthRouteAPI');
