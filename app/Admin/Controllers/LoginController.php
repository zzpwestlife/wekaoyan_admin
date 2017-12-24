<?php

namespace App\Admin\Controllers;

use App\AdminUser;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('/login/index');
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

        $user = request(['name', 'password']);

        $userExist = AdminUser::where('name', $user['name'])->where('password', bcrypt($user['password']))->count();
//        if (true == \Auth::guard('admin')->attempt($user)) {
        if ($userExist) {
            return redirect('/home');
        } else {
            return \Redirect::back()->withErrors("用户名密码错误");
        }

    }

    /*
     * 登出操作
     */
    public function logout()
    {
        \Auth::guard('admin')->logout();
        return redirect('/login');
    }
}
