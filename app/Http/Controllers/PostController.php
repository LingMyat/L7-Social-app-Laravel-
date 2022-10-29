<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //post Create Page
    public function postCreatePage(){
        return view('user.post.postCreate');
    }
    //post Create
    public function postCreate(PostRequest $request){
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = fileStorage($request);
            Post::create($validated);
            return to_route('user#home');
        } else {
            return back()->with('imgNeed','The image field is required.');
        }
    }
    //post Edit
    public function postEdit(Post $id){
        return view('user.post.postEdit',['post'=>$id]);
    }
    //post Update
    public function postUpdate(Post $id,PostRequest $request){
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = fileStorage($request);
            Storage::delete('public/'.$id->image);
        } else {
            $validated['image'] = $id->image;
        }
        $id->update($validated);
        return to_route('user#home');
    }
    //post Delete
    public function postDelete(Post $id){
        $id->delete();
        return to_route('user#home');
    }
}
