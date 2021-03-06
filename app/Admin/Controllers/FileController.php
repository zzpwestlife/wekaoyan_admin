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

        $userId = intval($request->input('user_id', 0));
        $forumId = intval($request->input('forum_id', 0));
        $startTime = trim($request->input('start_time', ''));
        $endTime = trim($request->input('end_time', ''));
        $name = trim($request->input('name', ''));
        $query = File::with('forum')->with('user')->orderBy('updated_at', 'desc');

        if (!empty($name)) {
                $query->where('filename', 'like', '%' . $name . '%');
        }

        if (!empty($startTime) && !empty($endTime) && ($endTime > $startTime)) {
            $query->where('updated_at', '>', $startTime);
            $query->where('updated_at', '<', $endTime);
        }

        if (!empty($userId)) {
            $query->where('user_id', $userId);
        }

        if (!empty($forumId)) {
            $query->where('forum_id', $forumId);
        }
        $query = $query->paginate();

        $forums = Forum::orderBy('updated_at', 'desc')->get();
        $users = User::orderBy('updated_at', 'desc')->get();

        $returnData = [
            'files' => $query,
            'searchParams' => [
                'startTime' => $startTime,
                'endTime' => $endTime,
                'name' => $name,
                'user_id' => $userId,
                'forum_id' => $forumId,
            ],
            'forums' => $forums,
            'users' => $users
        ];
        return view('/file/index', $returnData);
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

        $forums = Forum::orderBy('updated_at', 'desc')->get();
        $users = User::orderBy('updated_at', 'desc')->get();

        $fileTypes = File::$fileTypes;
        return view('file/create', compact('file', 'forums', 'users', 'courseTypes', 'fileTypes'));
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
//            'filename' => 'required|min:4|max:100',
            'forum_id' => 'required|min:1',
            'user_id' => 'required|min:1'
        ]);

        $now = (new Carbon())->toDateTimeString();
        $type = intval($request->input('type', 0));
        $forumId = intval($request->input('forum_id', 0));
        $userId = intval($request->input('user_id', 0));
        $filename = trim($request->input('filename', ''));
        $downloads = intval($request->input('downloads', 0));
        $downloadsVirtual = intval($request->input('downloads_virtual', 0));
        $updatedAt = trim($request->input('updated_at', $now));
        $fileInfo = $request->input('file_info', []);

        if (empty($id)) {
            if (!empty($fileInfo)) {
                foreach ($fileInfo as $item) {
                    $oneItem = json_decode($item, true);
                    $data = [
                        'type' => $type,
                        'forum_id' => $forumId,
                        'user_id' => $userId,
                        'filename' => $oneItem['filename'],
                        'downloads' => $downloads,
                        'downloads_virtual' => $downloadsVirtual,
                        'status' => File::STATUS_VALID,
                        'path' => $oneItem['path'],
                        'uri' => $oneItem['uri'],
                        'hash' => $oneItem['hash'],
                    ];

                    File::create($data);
                }
            }
        } else {
            $data = [
                'type' => $type,
                'forum_id' => $forumId,
                'user_id' => $userId,
                'downloads' => $downloads,
                'downloads_virtual' => $downloadsVirtual,
                'status' => File::STATUS_VALID,
                'updated_at' => $updatedAt,
            ];

            if (!empty($filename)) {
                $data['filename'] = $filename;
            }

            File::where('id', $id)->update($data);
        }

        return redirect('/files');
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
        if ($request->isMethod('get')) {
            $path = $request->input('path');
//            if (!unlink($path)) {
            if (!rename($path, $path . '.' . time() . '.' . 'deleted')) {
                $returnData = [
                    'error' => 1,
                    'msg' => '文件删除失败'
                ];
            } else {
                $returnData = [
                    'error' => 0,
                    'msg' => '文件删除成功'
                ];
            }
        } elseif ($request->isMethod('post')) {
            $id = $request->input('id', 0);
            if (empty($id)) {
                $returnData = [
                    'error' => 1,
                    'msg' => '文件 id 不能为空'
                ];
            } else {
                $file = File::find($id);
                if (!empty($file->path) && is_file($file->path)) {
                    rename($file->path, $file->path . '.' . time() . '.' . 'deleted');
//                    unlink($file->path);
                }
                File::destroy($id);
                $returnData = [
                    'error' => 0,
                    'msg' => ''
                ];
            }
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
