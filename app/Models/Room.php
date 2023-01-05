<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','admin_id','deleted_at'
    ];
    const UPLOAD_PATH = 'upload/room';
    public function scopeActive($query)
    {
        return $query->where('active',true);
    }
    public function media(){
        return $this->morphOne(Media::class,'mediable');
    }
    public function admin(){
        return $this->belongsTo(User::class,'admin_id');
    }
}
