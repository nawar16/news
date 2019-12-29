<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserController as UserController;
use App\Http\Resources\PostsResource as PostsResource;
use App\Http\Resources\PostResource as PostResource;
use App\Http\Resources\CommentsResource as CommentsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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
        $p = Post::with(['comments', 'author', 'category'])->paginate(env('POST_PER_PAGE'));
        return new PostsResource($p);
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
            'title' => 'required' ,
            'content' => 'required' ,
            'category_id' => 'required' ,
        ]);
        $u = $request->user();
        $p = new Post();
        $p->title = $request->get('title');
        $p->content = $request->get('content');
        if( intval( $request->get('category_id')) != 0)
        {
            $p->category_id = intval( $request->get('category_id'));
        }
        $p->user_id = $u->id;
        $p->votes_up = 0;
        $p->votes_down = 0;
        $p->date_written = Carbon::now()->format('Y-m-d H:i:s');

        // TODO : handle 404 error
        if($request->hasFile('featured_image')){
            $featuredImage = $request->file('featured_image');
            $filename = time().$featuredImage->getClientOriginalName();
            $path = '/images';
            Storage::disk('public')->putFileAs(
                $path,
                $featuredImage,
                $filename
            );
            $p->featured_image = url('/').'/storage/app/public'.$path.'/'.$filename;
        }

        $p->save();
        return new PostResource($p);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $p = Post::with(['comments', 'author', 'category'])->where('id', $id)->get();
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
        
        $u = $request->user();
        $p = Post::find($id);

        if($request->has('title')){
        $p->title = $request->get('title');}

        if($request->has('content'))
        {$p->content = $request->get('content');}

        if($request->has('category_id'))
        {if( intval( $request->get('category_id')) != 0)
        {
            $p->category_id = intval( $request->get('category_id'));
        }}
        $p->date_written = Carbon::now()->format('Y-m-d H:i:s');

        // TODO : handle 404 error
        if($request->hasFile('featured_image')){
            $featuredImage = $request->file('featured_image');
            $filename = time().$featuredImage->getClientOriginalName();
            $path = '/images';
            Storage::disk('public')->putFileAs(
                $path,
                $featuredImage,
                $filename
            );
            $p->featured_image = url('/').'/storage/app/public'.$path.'/'.$filename;
        }

        $p->save();
        return new PostResource($p);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $p = Post::find($id);
        $p->delete();
        return new PostResource($p);
    }
}
