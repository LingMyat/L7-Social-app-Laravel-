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
        session()->put('ment',true);
        return back();
    }
    //commentDelete
    public function commentDelete(Request $request){
        Comment::find($request->id)->delete();
        return response()->json(['status'=>'success'],204);
    }
    //commentUpdate
    public function commentUpdate(Request $request,Comment $id){
        $id->update(['content'=>$request->content]);
        session()->put('ment',true);
        return back();
    }
}
