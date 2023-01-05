<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Room;
use App\Models\RoomMessage;
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
        $messages = RoomMessage::roomIn($request->roomId)->with('room','user')->all();
        return view('User.message.liveChat',compact('room'));
    }
    //storeMessage
    public function storeMessage(Request $request){
        RoomMessage::create([
            'room_id'=>$request->roomId,
            'user_id'=>$request->id,
            'message'=>$request->message
        ]);
    }
}
