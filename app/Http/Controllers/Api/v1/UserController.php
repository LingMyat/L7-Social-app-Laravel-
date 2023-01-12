<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\FriendResource;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    //friends
    public function friends(Request $request){
        $friends = FriendRequest::where([
            'reciever_id'=>auth()->id(),
        ])->status('fri')->get();
        return FriendResource::collection($friends)->additional(['message'=>'success']);
    }
}
