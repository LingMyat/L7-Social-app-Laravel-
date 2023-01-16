<?php

namespace App\Http\Controllers;

use App\Events\PublicEvent;
use App\Models\Post;
use App\Models\User;
use App\Models\Media;
use App\Mail\PostStore;
use App\Models\Comment;
use App\Mail\PostDelete;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostsResource;
use Illuminate\Support\Facades\File;
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
        $post = Post::create($validated);
        $path = Post::UPLOAD_PATH . "/" .date('Y').'/'.date('m').'/';
        foreach ($request->image_galleries as $key => $image) {
            $fileName = uniqid().time().'.'.$image->extension();
            $image->move(public_path($path),$fileName);
            Media::create([
                'image'=>$path.$fileName,
                'mediable_id'=>$post->id,
                'mediable_type'=>Post::class
            ]);
        }
        // event(new PublicEvent(new PostsResource($post)));
        return to_route('user#home')->with('success',"Post Created Successful!");
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
    public function postUpdate(Post $id,Request $request){
        $validated = $request->validate([
            'title'=>'required',
            'content'=>'required',
        ]);
        $path = Post::UPLOAD_PATH . "/" .date('Y').'/'.date('m').'/';
        if ($request->hasFile('image_galleries')) {
            foreach ($request->image_galleries as $key => $image) {
                $fileName = uniqid().time().'.'.$image->extension();
                $image->move(public_path($path),$fileName);
                Media::create([
                    'image'=>$path.$fileName,
                    'mediable_id'=>$id->id,
                    'mediable_type'=>Post::class
                ]);
            }
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
    public function deleteMediaPhoto(Media $id){
        File::delete(public_path($id->image));
        $id->delete();

        return redirect()->back();
    }
}
