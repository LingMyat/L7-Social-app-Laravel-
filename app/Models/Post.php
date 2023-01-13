<?php

namespace App\Models;

use App\Mail\PostStore;
use App\Models\Comment;
use App\Mail\PostDelete;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','content','title','image','deleted_at','active'
    ];

    const UPLOAD_PATH = "upload/post";

    public function scopeActive($query)
    {
        return $query->where("active",true);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function gallery(){
        return $this->morphMany(Media::class,'mediable');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // protected static function booted()
    // {
    //     static::created(function ($user) {
    //         Mail::to('lingmyataung@outlook.com')->send(new PostStore());
    //     });

    //     static::deleted(function ($user) {
    //         Mail::to('lingmyataung@outlook.com')->send(new PostDelete());
    //     });
    // }
}
