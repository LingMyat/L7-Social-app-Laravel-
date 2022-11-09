<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //Like Post
    public function like(Request $request){
        Like::create([
            'post_id'=>$request->post_id,
            'user_id'=>$request->user_id
        ]);
    }
    //unLike Post
    public function unLike(Request $request){
        Like::where('post_id',$request->post_id)->where('user_id',$request->user_id)->delete();
    }
}
