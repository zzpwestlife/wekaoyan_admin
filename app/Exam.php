<?php

namespace App;

class Exam extends Model
{

    protected $table = "exams";

    // 资料类型
    const FILE_TYPE_COUNT = 1;
    const FILE_TYPE_ESSAY = 2;
    const FILE_TYPE_NOUN = 3;
    const FILE_TYPE_CHOOSE = 4;
    const FILE_TYPE_CALCULATE = 5;
    const FILE_TYPE_BRIEF = 6;

    public static $examTypes = [
        self::FILE_TYPE_COUNT => '简单计算',
        self::FILE_TYPE_ESSAY => '论述',
        self::FILE_TYPE_NOUN => '名词解释',
        self::FILE_TYPE_CHOOSE => '选择',
        self::FILE_TYPE_CALCULATE => '计算',
        self::FILE_TYPE_BRIEF => '简答',
    ];

    public function file()
    {
        return $this->belongsTo('\App\File', 'file_id', 'id');
    }

    public function examComment()
    {
        return $this->hasMany('\App\ExamComment', 'exam_id', 'id');
    }

    public function getCommentCountAttribute()
    {
        return ExamComment::where('exam_id', $this->id)->count();
    }

}
