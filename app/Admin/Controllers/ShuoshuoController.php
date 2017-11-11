<?php

namespace App\Admin\Controllers;

use App\Forum;
use App\User;
use Illuminate\Http\Request;
use \App\Shuoshuo;

class ShuoshuoController extends Controller
{
    /**
     * @comment 说说列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-10-27
     */
    public function index()
    {
        $shuoshuos = Shuoshuo::whereNull('deleted_at')->with('user')->with('forum')->orderBy(
            'updated_at',
            'desc'
        )->paginate();
//        dd($shuoshuos[0]->comment_count);
        return view('/admin/shuoshuo/index', compact('shuoshuos'));
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
            $shuoshuo = Shuoshuo::with('user')->with('forum')->find($id);
        } else {
            $shuoshuo = new Shuoshuo();
        }
        $users = User::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();
        $forums = Forum::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();

        return view('admin/shuoshuo/create', compact('shuoshuo', 'users', 'forums'));
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
        $content = trim($request->input('content', ''));
        $user_id = intval($request->input('user_id', 0));
        $forum_id = intval($request->input('forum_id', 0));
        $this->validate($request, [
            'content' => 'required|min:4|max:300',
            'user_id' => 'required|min:1',
            'forum_id' => 'required|min:1',
        ]);

        $data = compact('content', 'user_id', 'forum_id');
        if (empty($id)) {
            Shuoshuo::create($data);
        } else {
            Shuoshuo::where('id', $id)->update($data);
        }
        return redirect('/admin/shuoshuos');
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
                'msg' => '说说 id 不能为空'
            ];
        } else {
            Shuoshuo::destroy($id);
            $returnData = [
                'error' => 0,
                'msg' => ''
            ];
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }
}
