<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email'=>$this->email,
            'name'=>$this->name,
            'phone'=>$this->phone,
            "job"=> $this->job,
            'gender'=>$this->gender,
            'address'=>$this->address,
            'bio'=>$this->bio,
            'profile'=>$this->media->image??asset('assets/theme/default_user/defuser.png')
        ];
    }
}
