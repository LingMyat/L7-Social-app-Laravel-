<?php

namespace App\Models;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LiveChatMessage extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'user_id','room_id','message','parent_id'
    ];
    public function room(){
       return $this->belongsTo(Room::class,'room_id');
    }
    public function user()
    {
       return $this->belongsTo(User::class,'user_id');
    }
    public function scopeRoomIn($query,$roomId)
    {
        return $query->where('room_id',$roomId);
    }
    public function scopeOnlyParent($query)
    {
        return $query->whereNull('parent_id')->where('parent_id', null);
    }
    public function parent()
    {
        return $this->belongsTo(LiveChatMessage::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(LiveChatMessage::class, 'parent_id');
    }

    public function media()
    {
        return $this->morphOne(Media::class,'mediable');
    }
}
