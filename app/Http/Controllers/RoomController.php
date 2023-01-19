<?php

namespace App\Http\Controllers;

use App\Models\LiveChatMessage;
use App\Models\Media;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // index
    public function index(Request $request){
        $query = Room::orderBy('id','desc');
        if ($request->search) {
           $query->where(function($q) use($request){
            $q->where('name','like',"%$request->search%");
           });
        }
        $rooms = $query->with('media','admin')->active()->paginate(6);
        return view('User.Room.index',compact('rooms'));
    }
    //store
    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'image'=>'required'
        ]);
        $room = Room::create([
            'name'=>$request->name,
            'admin_id'=>auth()->user()->id,
        ]);
        $path = Room::UPLOAD_PATH."/".date('Y').'/'.date('m').'/';
        $fileName = uniqid().time().'.'.$request->file('image')->extension();
        $request->file('image')->move(public_path($path),$fileName);
        Media::create([
            'image'=>$path.$fileName,
            'mediable_id'=>$room->id,
            'mediable_type'=>Room::class
        ]);
        return back()->with('success',"Successfully Created $room->name Room");
    }

    //liveChat
    public function liveChat(Request $request){
        $room = Room::where('id',$request->roomId)->first();
        $messages = LiveChatMessage::roomIn($request->roomId)->onlyParent()->with('room','user','media')->get();
        $lastMessage = LiveChatMessage::orderBy('id','desc')->first();
        return view('User.message.liveChat',compact('room','messages','lastMessage'));
    }
    //storeMessage
    public function storeMessage(Request $request){
        if ($request->parent == 'true') {
            $parent = LiveChatMessage::roomIn($request->roomId)
            ->where('user_id',$request->id)
            ->onlyParent()
            ->orderBy('id','desc')
            ->first();
            LiveChatMessage::create([
                'room_id'=>$request->roomId,
                'user_id'=>auth()->id(),
                'message'=>$request->message,
                'parent_id'=>$parent->id
            ]);

        } else {
            LiveChatMessage::create([
                'room_id'=>$request->roomId,
                'user_id'=>auth()->id(),
                'message'=>$request->message,
            ]);
        }

    }

    //storeImage
    public function storeImage(Request $request)
    {
        $msg = LiveChatMessage::create([
            'room_id'=>$request->room_id,
            'user_id'=>auth()->id(),
            'message'=>''
        ]);
        $path = Room::UPLOAD_PATH.'/'.date('Y')."/".date('m')."/";
        $fileName = uniqid().time().'.'.$request->image->extension();
        $request->image->move(public_path($path),$fileName);
        Media::create([
            'image'=>$path.$fileName,
            'mediable_id'=>$msg->id,
            'mediable_type'=>LiveChatMessage::class
        ]);
    }
}
