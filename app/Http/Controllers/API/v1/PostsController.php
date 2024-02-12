<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Posts;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\v1\PostRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $posts = Posts::where('userId', $userId)
        ->orderBy('id', 'desc')
        ->get();
        if(empty($posts)){
            return response()->empty();
        }
        return response()->json([
            'data' => $posts
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $postData = $request->validated();
        $postData['userId'] = Auth::user()->id;
        $postData['date'] = now()->format('F j, Y');
        $post = Posts::create($postData);
        if(!$post){
            return response()->failed('Post Failed to Insert');
        }else {
            return response()->success($post, 'Post Inserted Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Posts::find($id);
        if(empty($post)){
            return response()->empty();
        }

        if(!$post){
            return response()->failed('Failed to show Post');
        }else {
            return response()->success($post, 'Post Fetched Successfully');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $postId = Posts::find($id);

        if(empty($postId)){
            return response()->empty();
        }

        $update = $postId->update($request->validated());

        if(!$update){
            return response()->failed('Failed to Update Post');
        }else{
            return response()->success(new PostResource($postId), 'Update Post Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $postsId = Posts::find($id);
        if(empty($postsId)){
            return response()->empty();
        }
        $delete = $postsId->delete();
        if(!$delete){
            return response()->failed('Failed to Delete Post');
        }else {
            return response()->success($postsId, 'Post Delete Successfully');
        }
    }
}
