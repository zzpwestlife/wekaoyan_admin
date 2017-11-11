<?php

namespace App;

class Question extends Model
{
    protected $table = "questions";
    protected $appends = ['short_content'];

    public function answers()
    {
        return $this->hasMany('\App\Answer', 'question_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }

    public function forum()
    {
        return $this->hasOne('\App\Forum', 'id', 'forum_id');
    }

    public function getShortContentAttribute()
    {
        return getShareContent($this->attributes['content']);
    }

    public function getAnswerCountAttribute()
    {
        return Answer::whereNull('deleted_at')->where('question_id', $this->id)->count();
    }
}
