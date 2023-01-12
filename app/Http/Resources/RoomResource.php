<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserInfoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'name'=>$this->name,
            'room_img'=>$this->media->image,
            'owner'=>new UserInfoResource($this->admin)
        ];
    }
}
