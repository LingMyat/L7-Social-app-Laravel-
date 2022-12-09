<?php

namespace App\Models;

use App\Mail\PostStore;
use App\Mail\PostDelete;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','content','title','image'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            Mail::to('bizkits223@gmail.com')->send(new PostStore());
        });

        static::deleted(function ($user) {
            Mail::to('bizkits223@gmail.com')->send(new PostDelete());
        });
    }
}
