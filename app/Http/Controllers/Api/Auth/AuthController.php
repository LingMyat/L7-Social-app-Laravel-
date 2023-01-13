<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\ResponseHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //register
    public function register(Request $request)
    {
        $request->validate([
        'name'=>'required',
        'email'=>'required|unique',
        'image'=>'mimes:png,jpg,jpeg',
        'phone'=>'required',
        'address'=>'required',
        'gender'=>'required',
        'password'=>'required',
        'confirm_password'=>'required|same:password'
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'gender'=>$request->gender,
        ]);
    }

    //login
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = new UserResource(auth()->user());
            $token = $user->createToken('L7Social')->accessToken;
            $data = [
                'user' => $user,
                'token'=> $token
            ];
            return ResponseHelper::success($data);
        } else {
            return ResponseHelper::fail("Something went wrong");
        }
    }

    //logout
    public function logout(Request $request){
        auth()->user()->token()->revoke();
        return ResponseHelper::success([],'Successfully Logout');
    }
}
