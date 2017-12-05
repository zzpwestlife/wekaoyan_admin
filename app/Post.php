<?php

namespace App;

class Post extends Model
{
    protected $table = "experiences";
    protected $appends = ['short_content'];

    public function comments()
    {
        return $this->hasMany('\App\PostComment', 'experience_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }

    public function forum()
    {
        return $this->hasOne('\App\Forum', 'id', 'forum_id');
    }

    public function postContent()
    {
        return $this->hasOne('\App\PostContent', 'experience_id', 'id');
    }

    public function getShortContentAttribute()
    {
        return getShareContent($this->attributes['content']);
    }

    public function getCommentCountAttribute()
    {
        return PostComment::where('experience_id', $this->id)->count();
    }
}
