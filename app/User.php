<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "users";

    protected $fillable = ['mobile', 'email', 'password', 'name', 'qq', 'weixin', 'email', 'avatar_url', 'is_teacher'];

}
