<?php

namespace App\Admin\Controllers;

use App\Shuoshuo;
use App\ShuoshuoComment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShuoshuoCommentController extends Controller
{
    /**
     * @comment 说说评论列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-10-27
     */
    public function index(Request $request)
    {
        $shuoshuoId = intval($request->input('shuoshuo_id', 0));
        if (empty($shuoshuoId)) {
            $shuoshuo = new \stdClass();
            $shuoshuoComments = new \stdClass();
        } else {
            $shuoshuo = Shuoshuo::find($shuoshuoId);
            $shuoshuoComments = ShuoshuoComment::where(
                'shuoshuo_id',
                $shuoshuoId
            )->whereNull('deleted_at')->with('user')->with('shuoshuo')->orderBy(
                'updated_at',
                'desc'
            )->paginate();
        }
        return view('/admin/shuoshuo_comment/index', compact('shuoshuo', 'shuoshuoComments'));
    }

    /**
     * @comment 添加说说评论
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-10-27
     */
    public function create(Request $request, $id = 0)
    {
        $shuoshuo_id = intval($request->input('shuoshuo_id', 0));

        if (empty($shuoshuo_id)) {
            return redirect('/');
        } else {
            $shuoshuo = Shuoshuo::find($shuoshuo_id);
        }

        if (empty($id)) {
            $shuoshuoComment = new ShuoshuoComment();
        } else {
            $shuoshuoComment = ShuoshuoComment::with('user')->with('shuoshuo')->find($id);
        }
        $users = User::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();
        $shuoshuos = Shuoshuo::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();

        return view('admin/shuoshuo_comment/create', compact('shuoshuoComment', 'users', 'shuoshuos', 'shuoshuo'));
    }

    /**
     * @comment 更新说说评论
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2017-10-27
     */
    public function store(Request $request)
    {
        $id = intval($request->input('id', 0));
        $user_id = intval($request->input('user_id', 0));
        $shuoshuo_id = intval($request->input('shuoshuo_id', 0));
        $content = trim($request->input('content', ''));
        $data = compact('user_id', 'shuoshuo_id', 'content');

        if (empty($shuoshuo_id)) {
            return redirect('/');
        }

        $this->validate($request, [
            'content' => 'required|min:4|max:300',
            'user_id' => 'required|min:1'
        ]);
        if (empty($id)) {
            $new = ShuoshuoComment::create($data);
        } else {
            $new = ShuoshuoComment::where('id', $id)->update($data);
        }
        return redirect('/admin/shuoshuo_comments?shuoshuo_id=' . $shuoshuo_id);
    }

    /**
     * @comment 删除说说评论
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
            ShuoshuoComment::destroy($id);
            $returnData = [
                'error' => 0,
                'msg' => ''
            ];
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }
}
