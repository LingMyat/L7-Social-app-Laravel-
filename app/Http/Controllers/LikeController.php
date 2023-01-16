<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //Like Post
    public function like(Request $request){
        $like = Like::create([
            'post_id'=>$request->post_id,
            'user_id'=>$request->user_id
        ]);
        $message = auth()->user()->name." like your post";
        $id = $like->post->user->id;
        noti($id,$message);
        return response()->json(['status'=>'success',200]);
    }
    //unLike Post
    public function unLike(Request $request){
        Like::where('post_id',$request->post_id)->where('user_id',$request->user_id)->delete();
        return response()->json(['status'=>'success',200]);
    }
}
