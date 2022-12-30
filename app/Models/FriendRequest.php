<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FriendRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id','reciever_id','status'
    ];
    public function sender(){
        return $this->belongsTo(User::class,'sender_id');
    }
    public function reciever(){
        return $this->belongsTo(User::class,'reciever_id');
    }
    public function scopeStatus($query,$status)
    {
        return $query->where('status',$status);
    }
    public function scopeNotEqualStatus($query, $status)
    {
        return $query->where('status', '!=', $status);
    }
}
