<?php

namespace App\Admin\Controllers;

use App\Post;
use App\PostComment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostCommentController extends Controller
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
        $postId = intval($request->input('post_id', 0));
        if (empty($postId)) {
            $post = new \stdClass();
            $postComments = new \stdClass();
        } else {
            $post = Post::find($postId);
            $postComments = PostComment::where(
                'experience_id',
                $postId
            )->with('user')->with('post')->orderBy(
                'updated_at',
                'desc'
            )->paginate();
        }
        return view('/post_comment/index', compact('post', 'postComments'));
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
        $post_id = intval($request->input('post_id', 0));

        if (empty($post_id)) {
            return redirect('/');
        } else {
            $post = Post::find($post_id);
        }

        if (empty($id)) {
            $postComment = new PostComment();
        } else {
            $postComment = PostComment::with('user')->with('post')->find($id);
        }
        $users = User::orderBy('updated_at', 'desc')->get();
        $posts = Post::orderBy('updated_at', 'desc')->get();

        return view('post_comment/create', compact('postComment', 'users', 'posts', 'post'));
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
        $post_id = intval($request->input('post_id', 0));
        $content = trim($request->input('content', ''));
        $data = [
            'user_id' => $user_id,
            'experience_id' => $post_id,
            'content' => $content,
        ];

        if (empty($post_id)) {
            return redirect('/');
        }

        $this->validate($request, [
            'content' => 'required|min:4|max:300',
            'user_id' => 'required|min:1'
        ]);
        if (empty($id)) {
            $new = PostComment::create($data);
        } else {
            $new = PostComment::where('id', $id)->update($data);
        }
        return redirect('/post_comments?post_id=' . $post_id);
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
            PostComment::destroy($id);
            $returnData = [
                'error' => 0,
                'msg' => ''
            ];
        }

        return response()->json($returnData)->setCallback($request->input('callback'));
    }
}
