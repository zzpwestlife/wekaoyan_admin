<?php

namespace App;

class PostComment extends Model
{
    protected $table = "experience_commentss";

    public function post()
    {
        return $this->belongsTo('\App\Post', 'experience_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }

}
