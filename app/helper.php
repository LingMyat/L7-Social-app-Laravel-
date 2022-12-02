<?php

use App\Models\Like;
use App\Models\Message;

function fileStorage($request){
    $imgName = uniqid().$request->file('image')->getClientOriginalName();
    $request->file('image')->storeAs('public',$imgName);
    return $imgName;
}

function checkLiked($id){
    $like = Like::where('post_id',$id)->where('user_id',auth()->id())->first();
    if (empty($like)) {
        return false;
    } else {
        return true;
    }
}

function reactCount($id){
    $likes = Like::where('post_id',$id)->get();
    return count($likes);
}

function messageNoti(){
    return Message::where([
        'reciever_id'=>auth()->id(),
        'status'=>'unread'
    ])->get();
}
