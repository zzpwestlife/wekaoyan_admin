<?php

namespace App\Admin\Controllers;

use App\Exam;
use App\File;
use App\Forum;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * @comment 真题列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2018-01-27
     */
    public function index(Request $request)
    {
        $fileId = intval($request->input('file_id'));
        if (empty($fileId)) {
            return redirect('/');
        }

        $file = File::find($fileId);
        $exams = Exam::where('file_id', $fileId)->orderBy('updated_at', 'desc')->get();

        $returnData = [
            'file' => $file,
            'exams' => $exams
        ];
        return view('/exam/index', $returnData);
    }

    /**
     * @comment 创建真题
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2018-01-27
     */
    public function create(Request $request, $id = 0)
    {
        $fileId = intval($request->input('file_id'));
        if (empty($fileId)) {
            return redirect('/');
        }
        $file = File::find($fileId);
        if (!empty($id)) {
            $exam = Exam::with('file')->find($id);
        } else {
            $exam = new File();
        }

        $returnData = [
            'exam' => $exam,
            'exam_types' => Exam::$examTypes,
            'file' => $file

        ];
        return view('/exam/create', $returnData);
    }

    /**
     * @comment 编辑真题
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2018-01-27
     */
    public function store(Request $request)
    {
        $id = request('id');
        $this->validate($request, [
            'file_id' => 'required|min:1',
            'type' => 'required|min:1',
            'content' => 'required|min:1',
        ]);

        $type = intval($request->input('type', 0));
        $fileId = intval($request->input('file_id', 0));
        $content = trim($request->input('content', ''));

        $data = [
            'type' => $type,
            'file_id' => $fileId,
            'content' => $content,
        ];
        if (empty($id)) {
            Exam::create($data);
        } else {
            Exam::where('id', $id)->update($data);
        }

        return redirect('/exams?file_id=' . $fileId);
    }

    /**
     * @comment 删除真题
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
                'msg' => '真题删除失败'
            ];
        } elseif ($request->isMethod('post')) {
            $id = $request->input('id', 0);
            if (empty($id)) {
                $returnData = [
                    'error' => 1,
                    'msg' => '真题 id 不能为空'
                ];
            } else {
                Exam::destroy($id);
                $returnData = [
                    'error' => 0,
                    'msg' => ''
                ];
            }
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }

}
