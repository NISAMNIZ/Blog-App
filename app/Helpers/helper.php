<php


public function isLikedByUser()
{
    return $this->likes()->where('user_id', auth()->id())->exists();
}

public function likes()
{
    return $this->hasMany(Like::class);
}


?>
