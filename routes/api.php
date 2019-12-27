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
Route::get('/Authors', 'Api\UserController@index');
Route::get('/Authors/{id}', 'Api\UserController@show');
Route::get('/posts/Authors/{id}', 'Api\UserController@posts');
Route::get('/comments/Authors/{id}', 'Api\UserController@comments');
///////////end user related///////////

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
