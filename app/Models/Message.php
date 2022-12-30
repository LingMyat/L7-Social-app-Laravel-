<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'content','sender_id','reciever_id','status','deleted_at','active'
    ];
    public function scopeActive($query)
    {
        return $query->where("active",true);
    }
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
