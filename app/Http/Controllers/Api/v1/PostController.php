<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use App\Models\Like;
use App\Models\Post;
use App\Models\Media;
use App\Models\Comment;
use App\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostsResource;
use App\Http\Resources\CommentsResource;

class PostController extends Controller
{
    //index
    public function index(Request $request)
    {
        if ($request->post_id) {
            $post = Post::findOrFail($request->post_id);
            return ResponseHelper::success(new PostsResource($post));
        }
        $posts = Post::when(request('search'),function($data){
            $data->where('title','like','%'.request('search').'%');
        })->orderBy('id','desc')->with('gallery','user')->active()->get();
        return ResponseHelper::success(PostsResource::collection($posts));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'image_galleries'=>'required|mimes:png,jpg,jpeg'
        ]);
        DB::beginTransaction();
        try {
            $post = Post::create([
                'title'=>$request->title,
                'content'=>$request->content,
                'user_id'=>auth()->id()
            ]);
            $path = Post::UPLOAD_PATH.date('Y')."/".date('m')."/";
            $fileName = uniqid().time().'.'.$request->image_galleries->extension();
            $request->image_galleries->move(public_path($path),$fileName);
            Media::create([
                'image'=>$path.$fileName,
                'mediable_id'=>$post->id,
                'mediable_type'=>Post::class
            ]);
            DB::commit();
            return ResponseHelper::success(new PostsResource($post));
        } catch (Exception $err) {
            DB::rollBack();
            return ResponseHelper::fail($err->getMessage());
        }
    }

    //reactPost
    public function reactPost(Request $request)
    {
        if ($this->isLiked($request)) {
            return response()->json('Error',422);
        }
        Like::create([
            'post_id'=>$request->post_id,
            'user_id'=>auth()->id(),
        ]);
        return response()->json('Success',200);
    }

    //cancelReact
    public function cancelReact(Request $request)
    {
        if ($this->isLiked($request)) {
            Like::where([
                'post_id'=>$request->post_id,
                'user_id'=>auth()->id()
            ])->delete();
            return response()->json('Success',200);
        }
        return response()->json('Error',422);

    }

    //storeComment
    public function storeComment(Request $request)
    {
       $comment = Comment::create([
            'post_id'=>$request->post_id,
            'user_id'=>auth()->id(),
            'content'=>$request->message
        ]);
        return ResponseHelper::success(new CommentsResource($comment));
    }

    private function isLiked($request)
    {
        $status = Like::where([
            'post_id'=>$request->post_id,
            'user_id'=>auth()->id()
        ])->get()->first();
        return $status;
    }
}
