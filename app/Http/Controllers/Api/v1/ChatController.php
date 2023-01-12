<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessengerMessagesResource;
use App\Http\Resources\UserInfoResource;
use App\ResponseHelper;

class ChatController extends Controller
{
    //messenger
    public function messenger(Request $request)
    {
        $friend = User::where('id',$request->friend_id)->with('media')->first();
        $users = [$friend->id,auth()->user()->id];
        $query = Message::whereIn(
            'sender_id', $users
        )->whereIn(
            'reciever_id', $users
        );
        $messages = $query->get();
        $data = [
            'friend' => new UserInfoResource($friend),
            'messages' => MessengerMessagesResource::collection($messages)
        ];
        return ResponseHelper::success($data);
    }

    //storeMessage
    public function storeMessage(Request $request)
    {
        $message = Message::create([
            'sender_id'=>auth()->id(),
            'reciever_id'=>$request->reciever_id,
            'content'=>$request->message
        ]);
        return ResponseHelper::success($message);
    }
}
