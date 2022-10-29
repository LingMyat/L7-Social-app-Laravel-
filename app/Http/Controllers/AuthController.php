<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Login page
    public function loginPage(){
        return view('login');
    }
    //Register page
    public function registerPage(){
        return view('register');
    }
    //Logout
    public function logout(){
        Auth::logout();
        return to_route('auth#loginPage');
    }
    //Dashboard
    public function dashBoard(){
        if (auth()->user()->role == 'admin') {
            return to_route('admin#userList');
        } elseif(auth()->user()->role == 'user') {
            return to_route('user#home');
        }
    }
}
