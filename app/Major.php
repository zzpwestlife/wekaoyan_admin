<?php

namespace App;

class Major extends Model
{
    protected $table = "majors";

    public function school()
    {
        return $this->belongsTo('\App\School', 'school_id', 'id');
    }
//
//    public function user()
//    {
//        return $this->belongsTo('\App\User', 'user_id', 'id');
//    }
}
