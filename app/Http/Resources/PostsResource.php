<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'content'=>$this->content,
            'images'=>MediaResource::collection($this->gallery),
            "owner"=>new UserInfoResource($this->user),
            'react'=>LikeResource::collection($this->likes),
            'comments'=>CommentsResource::collection($this->comments)
        ];
    }
}
