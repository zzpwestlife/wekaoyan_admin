<?php

namespace App;

class Answer extends Model
{
    protected $table = "answers";

    public function question()
    {
        return $this->belongsTo('\App\Question', 'question_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }

    public function forum()
    {
        return $this->hasOne('\App\Forum', 'id', 'forum_id');
    }
}
