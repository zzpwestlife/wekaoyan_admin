<?php

namespace App\Admin\Controllers;

use App\Forum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Overtrue\Pinyin\Pinyin;

class TestController extends Controller
{
    public function index()
    {

        for ($i = 1; $i <= 312; $i++) {
            $rand = rand(50, 120);
            echo $rand . '\r\n';
            DB::delete("delete from `experience_upvotes` where `experience_upvotes`.experience_id={$i} limit {$rand}");
        }

        dd('test');
        $pinyin = new Pinyin();
        $str = '中央财经大学801经济学综合';
        mm($pinyin->abbr($str));
        mm($pinyin->convert($str));
        mm($pinyin->permalink($str));
        mm($pinyin->permalink($str, ''));
    }

}
