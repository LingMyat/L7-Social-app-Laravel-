<?php

use App\Models\Like;

function fileStorage($request){
    $imgName = uniqid().$request->file('image')->getClientOriginalName();
    $request->file('image')->storeAs('public',$imgName);
    return $imgName;
}

function checkLiked($id){
    $likes = Like::where('post_id',$id)->where('user_id',auth()->id())->first();
    if (empty($likes)) {
        return false;
    } else {
        return true;
    }
}
