<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    //userList
    public function userList(){
        $users = User::where('role','user')->paginate(6);
        return view('Admin.userList',compact('users'));
    }
    //postList
    public function postList(){
        $posts = Post::orderBy('id','desc')->paginate(6);
        return view('Admin.postList',compact('posts'));
    }
    //postCreatePage
    public function postCreatePage(){
        return view('Admin.postCreate');
    }
    //postCreate
    public function postCreate(PostRequest $request){
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image']=fileStorage($request);
            Post::create($validated);
            return to_route('admin#postList');
        }else{
            return back()->with('imgNeed','The image field is required.');
        }
    }
    //postView
    public function postView(Post $id){
        return view('Admin.postView',['post'=>$id]);
    }
    //postEdit
    public function postEdit(Post $id){
        return view('Admin.postEdit',['post'=>$id]);
    }
    //postUpdate
    public function postUpdate(Post $id,PostRequest $request){
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = fileStorage($request);//app/helper.php
            Storage::delete('public/'.$id->image);
        } else{
            $validated['image']=$id->image;
        }
        $id->update($validated);
        return to_route('admin#postList');
    }
    //postDelete
    public function postDelete(Post $id){
        $id->delete();
        return to_route('admin#postList');
    }

}
