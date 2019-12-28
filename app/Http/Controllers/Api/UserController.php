<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
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
        //
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
            //dd($u);
            $u = User::where('email', $request->get('email'))->first();//bring user by email if attempt successful
            $t = $u->api_token;
            return $t;
            //return new TokenResource(['token' -> $u->api_token]);
            //return redirect()->intended('dashboard');
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
        //
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
