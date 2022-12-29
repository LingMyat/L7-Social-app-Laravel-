<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'image','mediable_id','mediable_type'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getImageAttribute($value)
    {
        return asset($value);
    }
}
