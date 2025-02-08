<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected $table = "blog";


    function isLike()
    {
        return $this->hasMany(Like::class,'user_id');
    }

    public function likes()
{
    return $this->hasMany(Like::class,'blog_id');
}

public function user()
{
    return $this->hasOne(User::class,'id','user_id');
}

public function comments()
{
    return $this->hasMany(Comment::class);
}
}
