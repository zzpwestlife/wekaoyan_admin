<?php

namespace App\Admin\Controllers;

use App\File;
use App\Forum;
use App\Post;
use App\PostContent;
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
        $posts = Post::with('user')->with('forum')->orderBy(
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
            $post = Post::with('user')->with('forum')->with('postContent')->find($id);
        } else {
            $post = new Post();
        }

        $users = User::orderBy('updated_at', 'desc')->get();
        $forums = Forum::orderBy('updated_at', 'desc')->get();

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
        $count = intval($request->input('count', 0));
        $this->validate($request, [
            'title' => 'required|min:1',
            'content' => 'required|min:4',
            'user_id' => 'required|min:1',
            'forum_id' => 'required|min:1',
        ]);

        $data = [
            'user_id' => $user_id,
            'forum_id' => $forum_id,
            'title' => $title,
            'count' => $count,
            'content' => '',
        ];

        if (empty($id)) {
            $newPost = Post::create($data);
            $id = $newPost->id;
        } else {
            Post::where('id', $id)->update($data);
        }

        $postContent = PostContent::where('experience_id', $id)->count();
        if ($postContent) {
            PostContent::where('experience_id', $id)->update(['content' => $content]);
        } else {
            PostContent::create(['experience_id' => $id, 'content' => $content]);
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
            PostContent::where('experience_id', $id)->delete();
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
        $returnData = imageUpload($request->file('wangEditorImg'), 'posts', true);
        return response()->json($returnData)->setCallback($request->input('callback'));
    }
}
