<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id','user_id','content','deleted_at','active'
    ];

    public function scopeActive($query)
    {
        return $query->where('active',true);
    }

    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
