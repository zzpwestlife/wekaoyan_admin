<?php

namespace App\Admin\Controllers;

use App\File;
use App\Forum;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \App\School;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use JavaScript;

class FileController extends Controller
{
    /**
     * @comment 文件列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-11-11
     */
    public function index(Request $request)
    {
        $files = File::whereNull('deleted_at')->with('forum')->with('user')->orderBy('updated_at', 'desc')->paginate();
        return view('/admin/file/index', compact('files'));
    }

    /**
     * @comment 创建文件
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-11-11
     */
    public function create(Request $request, $id = 0)
    {
        if (!empty($id)) {
            $file = File::with('forum')->with('user')->find($id);
        } else {
            $file = new File();
        }

        $forums = Forum::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();
        $users = User::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();

        $fileTypes = File::$fileTypes;
        return view('admin/file/create', compact('file', 'forums', 'users', 'courseTypes', 'fileTypes'));
    }

    /**
     * @comment 编辑文件
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2017-11-11
     */
    public function store(Request $request)
    {
        $id = request('id');
        $this->validate($request, [
            'filename' => 'required|min:4|max:30',
            'forum_id' => 'required|min:1',
            'user_id' => 'required|min:1'
        ]);

        $type = intval($request->input('type', 0));
        $forumId = intval($request->input('forum_id', 0));
        $userId = intval($request->input('user_id', 0));
        $filename = trim($request->input('filename', ''));
        $downloads = intval($request->input('downloads', 0));

        $data = [
            'type' => $type,
            'forum_id' => $forumId,
            'user_id' => $userId,
            'filename' => $filename,
            'downloads' => $downloads,
            'status' => File::STATUS_VALID
        ];

        if (empty($id)) {
            File::create($data);
        } else {
            File::where('id', $id)->update($data);
        }
        return redirect('/admin/files');
    }

    /**
     * @comment 删除文件
     * @param Request $request
     * @return $this
     * @author zzp
     * @date 2017-11-11
     */
    public function delete(Request $request)
    {

        $id = $request->input('id', 0);
        if (empty($id)) {
            $returnData = [
                'error' => 1,
                'msg' => '文件 id 不能为空'
            ];
        } else {
            File::destroy($id);
            $returnData = [
                'error' => 0,
                'msg' => ''
            ];
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }

    /**
     * @comment 上传文件
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2017-11-11
     */
    public function upload(Request $request)
    {
        $returnData = fileUpload($request->file('file'), 'file');
        return response()->json($returnData)->setCallback($request->input('callback'));
    }
}
