<?php

namespace App;

class ShuoshuoComment extends Model
{
    protected $table = "shuoshuo_comments";

    public function shuoshuo()
    {
        return $this->belongsTo('\App\Shuoshuo', 'shuoshuo_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
}
