<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Mail\PostStore;
use App\Models\Comment;
use App\Mail\PostDelete;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostCreatedNotification;

class PostController extends Controller
{
    //post Create Page
    public function postCreatePage(){
        return view('user.post.postCreate');
    }
    //post Create
    public function postCreate(PostRequest $request){

        $validated = $request->validated();
        // if ($request->hasFile('image')) {
        //     // $user = User::find(1);
        //     // $user->notify(new PostCreatedNotification());
        //     // Notification::send(User::find(1), new PostCreatedNotification());
        //     $validated['image'] = fileStorage($request);
        //     Post::create($validated);

        //     return to_route('user#home');
        // } else {
        //     return back()->with('imgNeed','The image field is required.');
        // }
        $path = Post::UPLOAD_PATH . "/" .date('Y').'/'.date('m').'/';
        foreach ($request->image_galleries as $key => $image) {
            $fileName = uniqid().time().'.'.$image->extension();
        }
    }
    //postView
    public function postView(Post $id){
        $comments = Comment::where('post_id',$id->id)->get();
        return view('User.post.postView',['post'=>$id,'comments'=>$comments]);
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
        Storage::delete('public/'.$id->image);
        return to_route('user#home');
    }
}
