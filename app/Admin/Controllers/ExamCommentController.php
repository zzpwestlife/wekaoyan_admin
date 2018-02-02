<?php

namespace App\Admin\Controllers;

use App\Exam;
use App\ExamComment;
use App\User;
use Illuminate\Http\Request;

class ExamCommentController extends Controller
{
    /**
     * @comment 真题回复列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2018-01-27
     */
    public function index(Request $request)
    {
        $examId = intval($request->input('exam_id'));
        if (empty($examId)) {
            return redirect('/');
        }

        $exam = Exam::find($examId);
        $examComments = ExamComment::where('exam_id', $examId)->orderBy('updated_at', 'desc')->get();

        $returnData = [
            'exam' => $exam,
            'exam_comments' => $examComments
        ];
        return view('/exam_comment/index', $returnData);
    }

    /**
     * @comment 创建真题回复
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2018-01-27
     */
    public function create(Request $request, $id = 0)
    {
        $examId = intval($request->input('exam_id'));
        if (empty($examId)) {
            return redirect('/');
        }
        $exam = Exam::find($examId);
        if (!empty($id)) {
            $examComment = ExamComment::find($id);
        } else {
            $examComment = new ExamComment();
        }
        $users = User::orderBy('updated_at', 'desc')->get();

        $returnData = [
            'exam' => $exam,
            'exam_types' => Exam::$examTypes,
            'exam_comment' => $examComment,
            'users' => $users

        ];
        return view('/exam_comment/create', $returnData);
    }

    /**
     * @comment 编辑真题回复
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2018-01-27
     */
    public function store(Request $request)
    {
        $id = request('id');
        $this->validate($request, [
            'exam_id' => 'required|min:1',
            'user_id' => 'required|min:1',
            'content' => 'required|min:1',
        ]);

        $userId = intval($request->input('user_id', 0));
        $examId = intval($request->input('exam_id', 0));
        $content = trim($request->input('content', ''));

        $data = [
            'user_id' => $userId,
            'exam_id' => $examId,
            'content' => $content,
        ];
        if (empty($id)) {
            ExamComment::create($data);
        } else {
            ExamComment::where('id', $id)->update($data);
        }

        return redirect('/exam_comments?exam_id=' . $examId);
    }

    /**
     * @comment 删除真题回复
     * @param Request $request
     * @return $this
     * @author zzp
     * @date 2018-01-27
     */
    public function delete(Request $request)
    {
        if ($request->isMethod('get')) {
            $returnData = [
                'error' => 1,
                'msg' => '真题回复删除失败'
            ];
        } elseif ($request->isMethod('post')) {
            $id = $request->input('id', 0);
            if (empty($id)) {
                $returnData = [
                    'error' => 1,
                    'msg' => '真题回复 id 不能为空'
                ];
            } else {
                ExamComment::destroy($id);
                $returnData = [
                    'error' => 0,
                    'msg' => ''
                ];
            }
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }

    /**
     * @comment 上传真题回复
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2017-11-11
     */
    public function upload(Request $request)
    {
        $returnData = examUpload($request->exam('exam'), 'exam');
        return response()->json($returnData)->setCallback($request->input('callback'));
    }
}
