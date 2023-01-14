<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    protected $success = ['status'=>'Success'];
    //peopleList
    public function peopleList(Request $request)
    {
        $query = User::orderBy('id','desc')
                ->with('posts','reacts','comments','media')
                ->where('id', '!=', auth()->id());
        if ($request->search) {
            $query->where('name','like',"%$request->search%");
        }
        $users=$query->get();
        $friendsId = [];
        $respondId = [];
        $requestedId = [];
        $friends = FriendRequest::where('reciever_id',auth()->id())->status('fri')->get();
        foreach ($friends as $key => $friend) {
            array_push($friendsId,$friend->sender_id);
        }
        $friends = FriendRequest::where('reciever_id',auth()->id())->status('pending')->get();
        foreach ($friends as $key => $friend) {
            array_push($respondId,$friend->sender_id);
        }
        $friends = FriendRequest::where('sender_id',auth()->id())->status('pending')->get();
        foreach ($friends as $key => $friend) {
            array_push($requestedId,$friend->reciever_id);
        }
        return view('User.People.index',compact('users','friendsId','respondId','requestedId'));
    }

    //addFriend
    public function addFriend(Request $request,$id)
    {
        FriendRequest::create([
            'sender_id'=>auth()->id(),
            'reciever_id'=>$id,
            'status'=>'pending'
        ]);
        return response()->json($this->success,201);
    }

    //cancelRequest
    public function cancelRequest(Request $request ,$id)
    {
        FriendRequest::where([
            'sender_id'=>auth()->id(),
            'reciever_id'=>$id,
            'status'=>'pending'
        ])->delete();
        return response()->json($this->success,200);
    }

    //respondFriend
    public function respondFriend(Request $request ,$id)
    {
        FriendRequest::where([
            'sender_id'=>$id,
            'reciever_id'=>auth()->id(),
        ])->update([
            'status'=>'fri'
        ]);
        FriendRequest::create([
            'sender_id'=>auth()->id(),
            'reciever_id'=>$id,
            'status'=>'fri'
        ]);
        return response()->json($this->success,201);
    }

    //unfriend
    public function unfriend(Request $request,$id)
    {
        $users = [$id,auth()->id()];
        $query = FriendRequest::whereIn(
            'sender_id', $users
        )->whereIn(
            'reciever_id', $users
        );
        $query->delete();
        return response()->json($this->success,200);
    }

    //forgetMent
    public function forgetMent(Request $request)
    {
        session()->forget('ment');
    }
}
