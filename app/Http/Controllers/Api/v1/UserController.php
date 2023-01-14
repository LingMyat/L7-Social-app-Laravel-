<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\FriendResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\ResponseHelper;

class UserController extends Controller
{
    //index
    public function index(Request $request)
    {
        if ($request->user_id) {
            $user = User::findOrFail($request->user_id);
            return ResponseHelper::success(new UserResource($user));
        }
        $query = User::orderBy('id','desc');
        if ($request->search) {
            $query->where('name','like',"%$request->search%");
        }
        $users = $query->get();
        return UserResource::collection($users)->additional(['message'=>'Success']);
    }

    //friends
    public function friends(Request $request){
        $friends = FriendRequest::where([
            'reciever_id'=>auth()->id(),
        ])->status('fri')->get();
        return FriendResource::collection($friends)->additional(['message'=>'success']);
    }
}
