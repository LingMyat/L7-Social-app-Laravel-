<?php

use Pusher\Pusher;
use App\Models\Like;
use App\Models\Message;

// function fileStorage($request){
//     $imgName = uniqid().$request->file('image')->getClientOriginalName();
//     $request->file('image')->storeAs('public',$imgName);
//     return $imgName;
// }

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
    ])->status('unread')->get();
}

// function desc($query)
// {
//     return $query->orderBy('id','desc');
// }

function noti($user_id,$message)
{
    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
      );
      $pusher = new Pusher(
        '59ba2eab2eb53ae64ed6',
        '8eb8b0ef539f742cf5f1',
        '1539040',
        $options
      );

      $data['message'] = $message;
      $pusher->trigger("private.$user_id", 'private', $data);
}
