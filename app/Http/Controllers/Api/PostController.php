<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserController as UserController;
use App\Http\Resources\PostsResource as PostsResource;
use App\Http\Resources\PostResource as PostResource;
use App\Http\Resources\CommentsResource as CommentsResource;
use Illuminate\Http\Request;
use App\Post;
use App\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PostsResource(Post::paginate(env('POST_PER_PAGE')));
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
        $p = Post::find($id);
        return new PostResource($p);
    }
    /**
     * Display the comments for specified post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function comments( $id)
    {
        $p = Post::find($id);
        $c = $p->comments()->paginate(env('COMMENT_PER_PAGE'));
        return new CommentsResource($c);
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
