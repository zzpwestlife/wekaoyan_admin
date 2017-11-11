<?php

namespace App;

class Topic extends Model
{
    protected $table = "topics";

    /*
     * 属于这个主题的所有文章
     */
    public function posts()
    {
        return $this->belongsToMany(\App\Post::class, 'post_topics', 'topic_id', 'post_id');
    }
}
