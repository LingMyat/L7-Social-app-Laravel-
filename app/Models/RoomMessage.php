<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','room_id','message'
    ];
    public function room(){
        $this->belongsTo(Room::class,'room_id');
    }
    public function user()
    {
        $this->belongsTo(User::class,'user_id');
    }
    public function scopeRoomIn($query,$roomId)
    {
        return $query->where('room_id',$roomId);
    }
}
