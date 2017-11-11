<?php

namespace App\Admin\Controllers;

use App\Question;
use App\Answer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * @comment 问题答案列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-11-05
     */
    public function index(Request $request)
    {
        $questionId = intval($request->input('question_id', 0));
        if (empty($questionId)) {
            $question = new \stdClass();
            $answers = new \stdClass();
        } else {
            $question = Question::find($questionId);
            $answers = Answer::where(
                'question_id',
                $questionId
            )->whereNull('deleted_at')->with('user')->with('question')->orderBy(
                'updated_at',
                'desc'
            )->paginate();
        }

        return view('/admin/answer/index', compact('question', 'answers'));
    }

    /**
     * @comment 添加问题答案
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-11-05
     */
    public function create(Request $request, $id = 0)
    {
        $questionId = intval($request->input('question_id', 0));

        if (empty($questionId)) {
            return redirect('/');
        } else {
            $question = Question::find($questionId);
        }

        if (empty($id)) {
            $answer = new Answer();
        } else {
            $answer = Answer::with('user')->with('question')->find($id);
        }
        $users = User::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();
        $questions = Question::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();

        return view('admin/answer/create', compact('answer', 'users', 'questions', 'question'));
    }

    /**
     * @comment 更新问题答案
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2017-11-05
     */
    public function store(Request $request)
    {
        $id = intval($request->input('id', 0));
        $user_id = intval($request->input('user_id', 0));
        $question_id = intval($request->input('question_id', 0));
        $content = trim($request->input('content', ''));
        $data = compact('user_id', 'question_id', 'content');

        if (empty($question_id)) {
            return redirect('/');
        }

        $this->validate($request, [
            'content' => 'required|min:4|max:1000',
            'user_id' => 'required|min:1'
        ]);
        if (empty($id)) {
            $new = Answer::create($data);
        } else {
            $new = Answer::where('id', $id)->update($data);
        }

        return redirect('/admin/answers?question_id=' . $question_id);
    }

    /**
     * @comment 删除问题答案
     * @param Request $request
     * @return $this
     * @author zzp
     * @date 2017-11-05
     */
    public function delete(Request $request)
    {
        $id = intval($request->input('id', 0));
        if (empty($id)) {
            $returnData = [
                'error' => 1,
                'msg' => '问题 id 不能为空'
            ];
        } else {
            Answer::destroy($id);
            $returnData = [
                'error' => 0,
                'msg' => ''
            ];
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }
}
