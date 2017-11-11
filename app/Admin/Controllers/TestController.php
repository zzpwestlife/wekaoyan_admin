<?php

namespace App\Admin\Controllers;

use App\Forum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Overtrue\Pinyin\Pinyin;

class TestController extends Controller
{
    public function index()
    {
//        dd('test');
        $pinyin = new Pinyin();
        $str = '中央财经大学801经济学综合';
        mm($pinyin->abbr($str));
        mm($pinyin->convert($str));
        mm($pinyin->permalink($str));
        mm($pinyin->permalink($str, ''));
    }

}
