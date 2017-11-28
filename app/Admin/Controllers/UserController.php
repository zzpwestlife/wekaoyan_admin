<?php

namespace App\Admin\Controllers;

use App\User;
use Illuminate\Http\Request;

/**
 * @comment 这里是前端用户控制器
 * Class UserController
 * @package App\Admin\Controllers
 */
class UserController extends Controller
{
    /**
     * @comment 说说列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-10-27
     */
    public function index()
    {
        $users = User::orderBy('updated_at', 'desc')->paginate();
        return view('/admin/user/index', compact('users'));
    }

    /**
     * @comment 新建说说
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-10-27
     */
    public function create(Request $request, $id = 0)
    {
        if (!empty($id)) {
            $user = User::find($id);
        } else {
            $user = new User();
        }
        $users = User::orderBy('updated_at', 'desc')->get();

        return view('admin/user/create', compact('user', 'users'));
    }

    /**
     * @comment 更新说说
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2017-10-27
     */
    public function store(Request $request)
    {
        $id = intval($request->input('id', 0));
        $name = trim($request->input('name', ''));
        $mobile = trim($request->input('mobile', ''));
        $qq = trim($request->input('qq', ''));
        $weixin = trim($request->input('weixin', ''));
        $email = trim($request->input('email', ''));
        $password = trim($request->input('password', ''));
        $isTeacher = intval($request->input('is_teacher', 0));
        $this->validate($request, [
            'name' => 'required|min:1|max:20',
            'mobile' => 'required|min:11|max:11',
        ]);

        $data = [
            'name' => $name,
            'mobile' => $mobile,
            'qq' => $qq,
            'weixin' => $weixin,
            'email' => $email,
            'is_teacher' => $isTeacher,
        ];

        if (!empty($password)) {
            $data['password'] = bcrypt($password);
        }
        if (empty($id)) {
            User::create($data);
        } else {
            User::where('id', $id)->update($data);
        }
        return redirect('/admin/users');
    }

    /**
     * @comment 删除说说
     * @param Request $request
     * @return $this
     * @author zzp
     * @date 2017-10-27
     */
    public function delete(Request $request)
    {
        $id = intval($request->input('id', 0));
        if (empty($id)) {
            $returnData = [
                'error' => 1,
                'msg' => '用户 id 不能为空'
            ];
        } else {
            User::destroy($id);
            $returnData = [
                'error' => 0,
                'msg' => ''
            ];
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }
}
