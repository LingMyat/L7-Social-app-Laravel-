<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Media;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PasswordChangeRequest;

class UserController extends Controller
{
    //userHome
    public function userHome(){
        $posts = Post::when(request('search'),function($data){
            $data->where('title','like','%'.request('search').'%');
        })->orderBy('id','desc')->paginate(6);
        // $slug = Str::slug('LARAVEL   9 Framework STR Helper Function slug', '-');
        // dd($slug);
        return view('user.home',compact('posts'));
    }
    //user profile
    public function profile(User $id){
        $friendRequestOtherProfile = FriendRequest::where([
            'sender_id'=>$id->id,
            'reciever_id'=>auth()->id(),
            'status'=>'pending'
        ])->first();

        $friendRequestOtherProfile2 = FriendRequest::where([
            'sender_id'=>auth()->id(),
            'reciever_id'=>$id->id,
            'status'=>'pending'
        ])->first();

        $friendRequest = FriendRequest::where([
            'reciever_id'=>$id->id,
            'status'=>'pending'
        ])->get();

        $friends = FriendRequest::where([
            'reciever_id'=>$id->id,
            'status'=>'fri'
        ])->get();

        $friendRequestValues = [];
        $friendsValues = [];
        $friendRequestOtherProfileValues= true;
        $friendRequestOtherProfile2Value = true;
        foreach ($friendRequest as $row) {
            array_push($friendRequestValues,$row->sender_id);
        }

        foreach ($friends as $row) {
            array_push($friendsValues,$row->sender_id);
        }

        if (empty($friendRequestOtherProfile)) {
            $friendRequestOtherProfileValues = false;
        }

        if (empty($friendRequestOtherProfile2)) {
            $friendRequestOtherProfile2Value = false;
        }

        return view('User.account.profile',
        [
            'user'=>$id,
            'friendRequest'=>$friendRequest,
            'friendRequestValues'=>$friendRequestValues,
            'friends'=>$friends,
            'friendsValues'=>$friendsValues,
            'friendRequestOtherProfile'=>$friendRequestOtherProfile,
            'friendRequestOtherProfileValues'=>$friendRequestOtherProfileValues,
            'friendRequestOtherProfile2Value'=>$friendRequestOtherProfile2Value,
        ]);
    }
    //user profileUpdate
    public function profileUpdate(User $id,UserRequest $request){
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $path = User::UPLOAD_PATH . '/' . date('Y'). "/" . date('m') . '/';
            $fileName = uniqid().time().'.'.$request->file('image')->extension();
            $request->file('image')->move(public_path($path), $fileName);
            Media::create([
                'image'=> $path . $fileName,
                'mediable_id'=>$id->id,
                'mediable_type'=>User::class
            ]);
            if ($id->image != Null) {
                $media = Media::findOrFail('mediable_id',$id->id);
                File::delete(public_path($media->image));
            }
        } else {
            $validated['image']=$id->image;
        }
        $id->update($validated);
        return to_route('user#profile',$id->id)->with('success','Account Updated Successful');
    }
    //changePassword
    public function changePassword(User $id,PasswordChangeRequest $request){
        $validated=$request->validated();
        if (Hash::check($request->current_psw,$id->password)) {
            $id->update(['password'=>Hash::make($request->new_psw)]);
            return to_route('user#profile',$id->id)->with('success',"Password Updated Successful.");
        } else {
            return back()->with('error','Please enter a valid Current Password');
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
    //cancelRequest
    public function cancelRequest($id){
        FriendRequest::where([
            'reciever_id'=>$id,
            'sender_id'=>auth()->id(),
            'status'=>'pending'
        ])->delete();
        return response()->json(['status'=>'success',200]);
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
        FriendRequest::where([
            'sender_id'=>$request->user1,
            'reciever_id'=>$request->user2
        ])->delete();
        FriendRequest::where([
            'sender_id'=>$request->user2,
            'reciever_id'=>$request->user1
        ])->delete();
        return response()->json(['status'=>'success'],200);
    }
}
