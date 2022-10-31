<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    //commentCreate
    public function commentCreate(CommentRequest $request){
        Comment::create($request->validated());
        return back();
    }
}
