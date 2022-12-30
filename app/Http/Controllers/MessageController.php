<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\FriendRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //index
    public function index(){
        $unRead = messageNoti();

        $allMessages = Message::where('reciever_id',auth()->id())
        ->orderBy('id','desc')
        ->get();

        $sentMessage = Message::where('sender_id',auth()->id())
        ->orderBy('id','desc')
        ->get();

        $friends = FriendRequest::where([
            'reciever_id'=>auth()->id(),
        ])->status('fri')->get();
        return view('user.message.index',compact('friends','allMessages','unRead','sentMessage'));
    }
    //sendMessage
    public function sendMessage(MessageRequest $request){
        $data = Message::create($request->validated());
        $name = $data->reciever->name;
        return to_route('message#index')->with('success',"Message Sent to $name!");
    }
    //viewMessage
    public function viewMessage(Message $id){
        return view('User.message.viewMessage',['message'=>$id]);
    }
    //viewMyMessage
    public function viewMyMessage(Message $id){
        return view('User.message.viewMyMessage',['message'=>$id]);
    }
    //messageSendPage
    public function messageSendPage(User $id){
        return view('User.message.sendMessage',['reciever'=>$id]);
    }
    //deleteMessage
    public function deleteMessage(Message $id){
        $id->delete();
        return to_route('message#index')->with('success','Message Deleted Success!');
    }
    //readMessage
    public function readMessage(Request $request){
        Message::where('id',$request->id)->update(['status'=>'read']);
    }
}
