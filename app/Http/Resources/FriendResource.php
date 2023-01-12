<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
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
            'id' => $this->sender->id ?? $this->sender_id,
            'email'=>$this->sender->email,
            'name'=>$this->sender->name,
            'phone'=>$this->sender->phone,
            "job"=> $this->sender->job,
            'gender'=>$this->sender->gender,
            'address'=>$this->sender->address,
            'bio'=>$this->sender->bio,
            'profile'=>$this->sender->media->image??asset('assets/theme/default_user/defuser.png')
        ];
    }
}
