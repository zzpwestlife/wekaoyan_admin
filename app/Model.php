<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use SoftDeletes;
    public $timestamps = true;

    protected $guarded = [];
    // 有效
    const STATUS_VALID = 1;
    // 无效
    const STATUS_INVALID = 0;

    public function getAppends()
    {
        return $this->getArrayableAppends();
    }
}
