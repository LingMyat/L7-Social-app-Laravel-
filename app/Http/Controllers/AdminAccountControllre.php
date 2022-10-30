<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PasswordChangeRequest;

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

    // password change
    public function changePassword(User $id,PasswordChangeRequest $request){
        $validated=$request->validated();
        if (Hash::check($request->current_psw,$id->password)) {
            $id->update(['password'=>Hash::make($request->new_psw)]);
            return to_route('admin#profile',$id->id);
        } else {
            return back()->with('notMatch','Please enter a valid password');
        }
    }
}
