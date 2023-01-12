<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomMessagesResource extends JsonResource
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
            'room_id'=>$this->room_id,
            'message'=>$this->message,
            'sender'=>new UserInfoResource($this->user),
            'child_messages'=>RoomMessagesResource::collection($this->childs)
        ];
    }
}
