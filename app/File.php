<?php

namespace App;

class File extends Model
{

    protected $table = "files";

    public static $suffix = [
        '.doc',
        '.docx',
        '.pdf',
        '.zip',
        '.7z',
        '.jpg',
        '.png'
    ];

    // 课程类型
    const COURSE_TYPE_OPEN = 0;
    const COURSE_TYPE_MAJOR = 1;

    public static $courseTypes = [
        self::COURSE_TYPE_OPEN => '公开课',
        self::COURSE_TYPE_MAJOR => '专业课',
    ];

    // 资料类型
    const FILE_TYPE_EXAM = 0;
    const FILE_TYPE_MATERIAL = 1;

    public static $fileTypes = [
        self::FILE_TYPE_EXAM => '真题',
        self::FILE_TYPE_MATERIAL => '资料',
    ];

    public function forum()
    {
        return $this->belongsTo('\App\Forum', 'forum_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }
}
