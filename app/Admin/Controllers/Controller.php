<?php

namespace App\Admin\Controllers;

use App\AdminOperateLog;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;
    protected $userId;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->userId = Auth::id();
        $excepts = [
            '/login',
            '/logout',
        ];

        $route = request()->route();
        $uri = $route->getCompiled()->getStaticPrefix();
        $this->logRequest($uri);
        if (!in_array($uri, $excepts)) {
            $this->middleware('auth');

//            if (Auth::check() == false) {
//                return redirect('/admin/login/index');
//                return redirect()->guest('/admin/login');
//            }
        }
    }

    /**
     * @comment 操作日志
     * @param string $uri
     * @author zzp
     * @date 2017-11-20
     */
    protected function logRequest($uri)
    {
        $data = [
            'user_id' => !empty($this->userId) ? $this->userId : 0,
            'ip' => getClientIp(),
            'uri' => $uri,
            'get_params' => json_encode($_GET),
            'post_params' => json_encode($_POST),
            'ua' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
        ];
        AdminOperateLog::create($data);
    }
}
