<?php

namespace App\Admin\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;

    public function __construct()
    {
        $route = request()->route();
        $uri = $route->getCompiled()->getStaticPrefix();
        $excepts = [
            '/admin/login',
            '/admin/logout',
        ];

        if (!in_array($uri, $excepts)) {
            $this->middleware('auth');

//            if (Auth::check() == false) {
//                return redirect('/admin/login/index');
//                return redirect()->guest('/admin/login');
//            }
        }
    }
}
