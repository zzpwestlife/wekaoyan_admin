<?php

namespace App;

class PostContent extends Model
{
    protected $table = "experience_contents";

    public function post()
    {
        return $this->hasOne('\App\Post', 'id', 'experience_id');
    }

}
