<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAccountControllre extends Controller
{
    // Direct Profile
    public function profile(User $id){
        return view('Admin.adminAcc.profile',['user'=>$id]);
    }

    // profile Update
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
        return to_route('admin#profile',$id->id);
    }
}
