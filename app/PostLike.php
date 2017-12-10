<?php

namespace App;

class PostLike extends Model
{
    protected $table = "experience_upvotes";

    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }

    public function post()
    {
        return $this->hasOne('\App\Post', 'id', 'experience_id');
    }

}
