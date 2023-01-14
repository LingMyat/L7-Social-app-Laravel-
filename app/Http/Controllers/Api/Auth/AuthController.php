<?php

namespace App\Http\Controllers\Api\Auth;

use Exception;
use App\Models\User;
use App\Models\Media;
use App\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //register
    public function register(Request $request)
    {
        $request->validate([
        'name'=>'required',
        'email'=>'required|unique:users,email',
        'image'=>'mimes:png,jpg,jpeg',
        'phone'=>'required',
        'address'=>'required',
        'gender'=>'required',
        'password'=>'required',
        'confirm_password'=>'required|same:password'
        ]);
        DB::beginTransaction();
        try {
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'gender'=>$request->gender,
                'password'=>Hash::make($request->password)
            ]);
            $path = User::UPLOAD_PATH."/".date('Y').'/'.date('m').'/';
            $fileName = uniqid().time().'.'.$request->image->extension();
            $request->image->move(public_path($path),$fileName);
            Media::create([
                'image'=>$path.$fileName,
                'mediable_id'=>$user->id,
                'mediable_type'=>User::class
            ]);
            DB::commit();
            $token = $user->createToken('L7Social')->accessToken;
            $data = [
                'user'=>new UserResource($user),
                'token'=>$token
            ];
            return ResponseHelper::success($data);
        } catch (Exception $err) {
            DB::rollback();
            return ResponseHelper::fail($err->getMessage());
        }

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
