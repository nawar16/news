<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController as UserController;
use App\Http\Resources\UsersResource as UsersResource;
use App\Http\Resources\UserResource as UserResource;
use App\Http\Resources\AuthorPostsResource as AuthorPostsResource;
use App\Http\Resources\AuthorCommentsResource as AuthorCommentsResource;
use App\Http\Resources\TokenResource as TokenResource;
use App\User;

class UserController extends Controller
{
    
    public function AuthRouteAPI(Request $request){
        return $request->user();
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $u = \App\User::paginate(env('AUTHOR_PER_PAGE'));
        return new UsersResource($u);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request -> validate([
            'name' => 'required' ,
            'email' => 'required' ,
            'password' => 'required' ,
        ]);
        $u = new User();
        $u->name = $request->get('name');
        $u->email = $request->get('email');
        $u->password = Hash::make($request->get('password'));
        $u->save();
        return new UserResource($u);
    }
    /**
     * Store a newly token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getToken(Request $request)
    {
        $request -> validate([
            'email' => 'required' ,
            'password' => 'required' ,
        ]);
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            $u = User::where('email', $request->get('email'))->first();//bring user by email if attempt successful
            $t = $u->api_token;
            return new TokenResource(['token' => $t]);
        }
        return 'not found';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $id)
    {
        return new UserResource($id);
    }
    /**
     * Display the posts of the specified author.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function posts( $id )
    {
        $u = User::find($id);
        $p = $u->posts()->paginate(env('POST_PER_PAGE'));
        return new AuthorPostsResource($p);
    }
    /**
     * Display the comments of the specified author.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function comments( $id )
    {
        $u = User::find($id);
        $c = $u->comments()->paginate(env('COMMENT_PER_PAGE'));
        return new AuthorCommentsResource($c);
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
        $u = User::find($id);
        if($request->has('name')){
            $u->name = $request->get('name');

        }
        if($request->has('avatar')){
            $u->avatar = $request->get('avatar');
        }
        $u->save();
        return new UserResource($u);
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
