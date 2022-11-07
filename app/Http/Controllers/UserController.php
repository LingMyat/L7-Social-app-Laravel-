<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PasswordChangeRequest;
use App\Models\FriendRequest;

class UserController extends Controller
{
    //userHome
    public function userHome(){
        $posts = Post::when(request('search'),function($data){
            $data->where('title','like','%'.request('search').'%');
        })
        ->orderBy('id','desc')->paginate(6);
        return view('user.home',compact('posts'));
    }
    //user profile
    public function profile(User $id){
        $friendRequestOtherProfile = FriendRequest::where('sender_id',$id->id)
        ->where('reciever_id',auth()->id())
        ->where('status','pending')
        ->first();
        // dd($friendRequestOtherProfile->toArray());
        $friendRequest = FriendRequest::where('reciever_id',$id->id)
        ->where('status','pending')
        ->get();

        $friends = FriendRequest::where('reciever_id',$id->id)
        ->where('status','fri')
        ->get();
        $friendRequestValues = [];
        $friendsValues = [];
        foreach ($friendRequest as $row) {
            array_push($friendRequestValues,$row->sender_id);
        }
        foreach ($friends as $row) {
            array_push($friendsValues,$row->sender_id);
        }
        if (empty($friendRequestOtherProfile)) {
            $friendRequestOtherProfileValues = [];
        } else {
            $friendRequestOtherProfileValues=$friendRequestOtherProfile->reciever_id;
        }
        return view('User.account.profile',
        [
            'user'=>$id,
            'friendRequest'=>$friendRequest,
            'friendRequestValues'=>$friendRequestValues,
            'friends'=>$friends,
            'friendsValues'=>$friendsValues,
            'friendRequestOtherProfile'=>$friendRequestOtherProfile,
            'friendRequestOtherProfileValues'=>$friendRequestOtherProfileValues
        ]);
    }
    //user profileUpdate
    public function profileUpdate(User $id,UserRequest $request){
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image']=fileStorage($request);
            if ($id->image != Null) {
                Storage::delete('public/'.$id->image);
            }
        } else {
            $validated['image']=$id->image;
        }
        $id->update($validated);
        return to_route('user#profile',$id->id);
    }
    //changePassword
    public function changePassword(User $id,PasswordChangeRequest $request){
        $validated=$request->validated();
        if (Hash::check($request->current_psw,$id->password)) {
            $id->update(['password'=>Hash::make($request->new_psw)]);
            return to_route('user#profile',$id->id);
        } else {
            return back()->with('notMatch','Please enter a valid password');
        }
    }
    //addFriend
    public function addFriend(Request $request){
        FriendRequest::create([
            'sender_id'=>$request->sender,
            'reciever_id'=>$request->reciever,
            'status'=>'pending'
        ]);
        return response()->json(['status'=>'success'],201);
    }
    //respondFriend
    public function respondFriend(Request $request){
        FriendRequest::where('id',$request->id)->update(['status'=>'fri']);
        FriendRequest::create([
            'sender_id'=>$request->reciever,
            'reciever_id'=>$request->sender,
            'status'=>'fri'
        ]);
        return response()->json(['status'=>'success'],201);
    }
    //confirmFri
    public function confirmFri(Request $request){
        FriendRequest::where('id',$request->id)->update(['status'=>'fri']);
        FriendRequest::create([
            'sender_id'=>$request->sender,
            'reciever_id'=>$request->reciever,
            'status'=>'fri'
        ]);
        return response()->json(['status'=>'success'],201);
    }
    //deleteFriReq
    public function deleteFriReq(Request $request){
        FriendRequest::where('id',$request->id)->delete();
        return response()->json(['status'=>'success'],200);
    }
    //unFriend
    public function unFriend(Request $request){
        FriendRequest::where('sender_id',$request->user1)->where('reciever_id',$request->user2)->delete();
        FriendRequest::where('sender_id',$request->user2)->where('reciever_id',$request->user1)->delete();
        return response()->json(['status'=>'success'],200);
    }
}
