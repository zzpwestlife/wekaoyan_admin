<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('/admin/login/index');
    }

    /*
     * 具体登陆
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'password' => 'required|min:6|max:30',
        ]);

#        $user = request(['name', 'password']);
#        if (true == \Auth::guard('admin')->attempt($user)) {
#            return redirect('/admin/home');
#        }
#
#        return \Redirect::back()->withErrors("用户名密码错误");
	#}
	        $name = request('name');
        $password = request('password');
\Log::info('step1 name:' . $name . ' password:' . $password);
        $user = request(['name', 'password']);
        if (true == \Auth::guard('admin')->attempt($user)) {

\Log::info('step2 name:' . $name . ' password:' . $password);
            return redirect('/admin/home');
        }
\Log::info('step3 name:' . $name . ' password:' . $password);
        return \Redirect::back()->withErrors("用户名密码错误");
    
    }

    /*
     * 登出操作
     */
    public function logout()
    {
        \Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
