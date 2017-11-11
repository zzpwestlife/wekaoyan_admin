<?php

namespace App\Admin\Controllers;

use App\File;
use App\Forum;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @comment 帖子列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-10-27
     */
    public function index()
    {
        $posts = Post::whereNull('deleted_at')->with('user')->with('forum')->orderBy(
            'updated_at',
            'desc'
        )->paginate();

        return view('/admin/post/index', compact('posts'));
    }

    /**
     * @comment 新建帖子
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author zzp
     * @date 2017-10-27
     */
    public function create(Request $request, $id = 0)
    {
        if (!empty($id)) {
            $post = Post::with('user')->with('forum')->find($id);
        } else {
            $post = new Post();
        }
        $users = User::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();
        $forums = Forum::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();

        return view('admin/post/create', compact('post', 'users', 'forums'));
    }

    /**
     * @comment 更新帖子
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author zzp
     * @date 2017-10-27
     */
    public function store(Request $request)
    {
        $id = intval($request->input('id', 0));
        $title = trim($request->input('title', ''));
        $content = trim($request->input('content', ''));
        $user_id = intval($request->input('user_id', 0));
        $forum_id = intval($request->input('forum_id', 0));
        $this->validate($request, [
            'title' => 'required|min:4',
            'content' => 'required|min:4',
            'user_id' => 'required|min:1',
            'forum_id' => 'required|min:1',
        ]);

        $data = compact('content', 'user_id', 'forum_id', 'title');

        if (empty($id)) {
            Post::create($data);
        } else {
            Post::where('id', $id)->update($data);
        }

        if ($request->ajax()) {
            $returnData = [
                'error' => 0,
                'msg' => '成功'
            ];
            return response()->json($returnData)->setCallback($request->input('callback'));
        }
        return redirect('/admin/posts');
    }

    /**
     * @comment 删除帖子
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
                'msg' => '帖子 id 不能为空'
            ];
        } else {
            Post::destroy($id);
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
     * @date 2017-11-03
     */
    public function imageUpload(Request $request)
    {
        $returnData = [
            'errno' => -1,
            'msg' => '',
            'data' => ''
        ];
        $file = $request->file('wangEditorImg');

        $path = sprintf('%s/posts/%s/', APP_ROOT, Carbon::now()->month);
//        autoMakeDir($path);

//        var_dump($file->getError()); // 0
//        var_dump($file->getFilename()); // php3R7aUM
//        var_dump($file->getExtension());
//        var_dump($file->getClientMimeType()); // image/png
//        var_dump($file->getClientOriginalExtension()); // png
//        var_dump($file->getClientOriginalName()); // bef3df8aly1fbx05q2ra1j20b40b4mxi.png
//        var_dump($file->getErrorMessage()); // The file "bef3df8aly1fbx05q2ra1j20b40b4mxi.png" was not uploaded due to an unknown error.
//        var_dump($file->getBasename()); // php3R7aUM
//        var_dump($file->getPath()); // /tmp
//        var_dump($file->getPathname()); // /tmp/php3R7aUM
//        var_dump($file->getType()); // file
//        var_dump($file->getRealPath()); // /tmp/php3R7aUM

        $error = $file->getError();
        if ($error != 0) {
            $returnData['msg'] = $file->getErrorMessage();
        } else {
            $fileExt = $file->getClientOriginalExtension();
            // 新文件名
            $newFilename = sprintf('%s_%s.%s', time(), rand(10000, 99999), $fileExt);
            // 移动文件
            $filePath = $path . $newFilename;
            $file->move($path, $newFilename);
            $returnData['errno'] = 0;
            $fileUrl = sprintf('%s/posts/%s/', APP_URL, Carbon::now()->month) . $newFilename;
            // http://wekaoyan_admin.dev.com/posts/11/1510388528_47787.jpg
            $returnData['data'] = [$fileUrl];
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }
}
