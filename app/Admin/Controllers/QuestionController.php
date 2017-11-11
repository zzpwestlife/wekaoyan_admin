<?php

namespace App\Admin\Controllers;

use App\Forum;
use App\Question;
use App\User;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @comment 问答列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-11-04
     */
    public function index()
    {
        $questions = Question::whereNull('deleted_at')->with('user')->with('forum')->orderBy(
            'updated_at',
            'desc'
        )->paginate();

//        dd($questions);
        return view('/admin/question/index', compact('questions'));
    }

    /**
     * @comment 新建问答
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-11-04
     */
    public function create(Request $request, $id = 0)
    {
        if (!empty($id)) {
            $question = Question::with('user')->with('forum')->find($id);
        } else {
            $question = new Question();
        }
        $users = User::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();
        $forums = Forum::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();

        return view('admin/question/create', compact('question', 'users', 'forums'));
    }

    /**
     * @comment 更新问答
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2017-11-04
     */
    public function store(Request $request)
    {
        $id = intval($request->input('id', 0));
        $title = trim($request->input('title', ''));
        $content = trim($request->input('content', ''));
        $user_id = intval($request->input('user_id', 0));
        $forum_id = intval($request->input('forum_id', 0));
        $this->validate($request, [
            'title' => 'required|min:4|max:100',
            'content' => 'required|min:4',
            'user_id' => 'required|min:1',
            'forum_id' => 'required|min:1',
        ]);

        $data = compact('title', 'content', 'user_id', 'forum_id');

        if (empty($id)) {
            Question::create($data);
        } else {
            Question::where('id', $id)->update($data);
        }

        if ($request->ajax()) {
            $returnData = [
                'error' => 0,
                'msg' => '成功'
            ];
            return response()->json($returnData)->setCallback($request->input('callback'));
        }
        return redirect('/admin/questions');
    }

    /**
     * @comment 删除问答
     * @param Request $request
     * @return $this
     * @author zzp
     * @date 2017-11-04
     */
    public function delete(Request $request)
    {
        $id = intval($request->input('id', 0));
        if (empty($id)) {
            $returnData = [
                'error' => 1,
                'msg' => '问答 id 不能为空'
            ];
        } else {
            Question::destroy($id);
            $returnData = [
                'error' => 0,
                'msg' => ''
            ];
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }

    /**
     * @comment 上传图片
     * @param Request $request
     * @return $this
     * @author zzp
     * @date 2017-11-04
     */
//    public function imageUpload(Request $request)
//    {
//        // TODO 测试storage link 生成的路径是否只是在Linux下能访问
//        $path = $request->file('wangEditorImg')->storePublicly(microtime(true) * 10000);
//
//        $returnData = [
//            'errno' => 0,
//            'data' => [
//                asset('storage/' . $path)
//            ]
//        ];
//        return response()->json($returnData)->setCallback($request->input('callback'));
//    }
}
