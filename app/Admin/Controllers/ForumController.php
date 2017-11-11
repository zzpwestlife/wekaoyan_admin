<?php

namespace App\Admin\Controllers;

use App\Forum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Overtrue\Pinyin\Pinyin;

class ForumController extends Controller
{
    /**
     * @comment 论坛列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-10-27
     */
    public function index()
    {
        $forums = Forum::whereNull('deleted_at')->orderBy('updated_at', 'desc')->paginate();
        return view('/admin/forum/index', compact('forums'));
    }

    /**
     * @comment 新建论坛
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-10-27
     */
    public function create(Request $request, $id = 0)
    {
        if (!empty($id)) {
            $forum = Forum::find($id);
        } else {
            $forum = new Forum();
        }
        return view('admin/forum/create', compact('forum'));
    }

    /**
     * @comment 更新论坛
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2017-10-27
     */
    public function store(Request $request)
    {
        $id = intval($request->input('id', 0));
        $name = trim($request->input('name', ''));
        $pinyin = new Pinyin();
        $alias = $pinyin->permalink($name, '');
        $alias_abbr = $pinyin->abbr($name, '');

        $data = compact('name', 'alias', 'alias_abbr');
        if (empty($id)) {
            $this->validate($request, [
                'name' => 'required|min:4|max:30|unique:forums,name'
            ]);
            Forum::create($data);
        } else {
            $this->validate($request, [
                'name' => 'required|min:4|max:30'
            ]);
            Forum::where('id', $id)->update($data);
        }
        return redirect('/admin/forums');
    }

    /**
     * @comment 删除论坛
     * @param Request $request
     * @return $this
     * @author zzp
     * @date 2017-10-27
     */
    public function delete(Request $request)
    {
        $id = $request->input('id', 0);
        if (empty($id)) {
            $returnData = [
                'error' => 1,
                'msg' => '论坛 id 不能为空'
            ];
        } else {
            Forum::destroy($id);
            $returnData = [
                'error' => 0,
                'msg' => ''
            ];
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }
}
