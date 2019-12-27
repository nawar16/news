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
use App\Http\Resources\UsersResource as UserResource;
use App\User;

Route::get('/users', function () {
    $u = \App\User::paginate();
    return new UserResource($u);
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
