<?php

namespace App;

class Exam extends Model
{

    protected $table = "exams";

    // 资料类型
    const FILE_TYPE_CALCULATE = 1;
    const FILE_TYPE_ESSAY = 2;

    public static $examTypes = [
        self::FILE_TYPE_CALCULATE => '简单计算',
        self::FILE_TYPE_ESSAY => '论述',
    ];

    public function file()
    {
        return $this->belongsTo('\App\File', 'file_id', 'id');
    }

    public function examComment()
    {
        return $this->hasMany('\App\ExamComment', 'exam_id', 'id');
    }

}
