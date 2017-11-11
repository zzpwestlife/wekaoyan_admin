<?php

namespace App;

class Shuoshuo extends Model
{
    protected $table = "shuoshuos";

    public function comments()
    {
        return $this->hasMany('\App\ShuoshuoComment', 'shuoshuo_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }

    public function forum()
    {
        return $this->hasOne('\App\Forum', 'id', 'forum_id');
    }

    public function getCommentCountAttribute()
    {
        return ShuoshuoComment::whereNull('deleted_at')->where('shuoshuo_id', $this->id)->count();
    }
}
