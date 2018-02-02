<?php

namespace App;

class ExamComment extends Model
{

    protected $table = "exam_comments";

    public function exam()
    {
        return $this->belongsTo('\App\Exam', 'id', 'exam_id');
    }

    public function user()
    {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }

}
