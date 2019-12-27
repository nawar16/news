<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UsersResource as UsersResource;
use App\Http\Resources\UserResource as UserResource;
use App\Http\Resources\AuthorPostsResource as AuthorPostsResource;
use App\Http\Resources\AuthorCommentsResource as AuthorCommentsResource;
use App\User;

class UserController extends Controller
{
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
