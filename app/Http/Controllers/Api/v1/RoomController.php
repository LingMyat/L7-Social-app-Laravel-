<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Room;
use App\ResponseHelper;
use Illuminate\Http\Request;
use App\Models\LiveChatMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomMessagesResource;
use App\Http\Resources\RoomResource;
use App\Http\Resources\UserInfoResource;

class RoomController extends Controller
{
    //rooms
    public function index(Request $request)
    {
        $query = Room::orderBy('id','desc');
        if ($request->search) {
           $query->where('name','like',"%$request->search%");
        }
        $rooms = $query->with('media','admin')->active()->get();
        return RoomResource::collection($rooms)->additional(['message'=>'Success']);
    }

    //room Messages
    public function roomMessages(Request $request)
    {
        $room = Room::where('id',$request->room_id)->first();
        $messages = LiveChatMessage::roomIn($request->room_id)->onlyParent()->with('room','user','media')->get();
        $lastMessage = LiveChatMessage::orderBy('id','desc')->first();
        $data = [
            'room'=>new RoomResource($room),
            'messages'=>RoomMessagesResource::collection($messages),
            'last_sender'=>new UserInfoResource($lastMessage->user)
        ];
        return ResponseHelper::success($data);
    }

    //storeRoomMessage
    public function storeRoomMessage(Request $request)
    {
        $lastMessage = LiveChatMessage::orderBy('id','desc')->roomIn($request->room_id)->first();
        if ($lastMessage->user_id == $request->id) {
            $parent = LiveChatMessage::roomIn($request->room_id)
            ->where('user_id',$request->id)
            ->onlyParent()
            ->orderBy('id','desc')
            ->first();
            $message = LiveChatMessage::create([
                'room_id'=>$request->room_id,
                'user_id'=>$request->id,
                'message'=>$request->message,
                'parent_id'=>$parent->id
            ]);
            return ResponseHelper::success($message);
        }
        $message = LiveChatMessage::create([
            'room_id'=>$request->room_id,
            'user_id'=>$request->id,
            'message'=>$request->message,
        ]);
        return ResponseHelper::success($message);
    }
}
