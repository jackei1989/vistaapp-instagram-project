<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * 
     * 
     */
    protected $userNotAuth = [
        'status'    => 'error',
        'massage'   => 'هویت کاربر نا مشخص است',
        'data'  => []
    ];

    protected $notFoundPost = [
        'status'    => 'error',
        'massage'   => 'پست مورد نظر یافت نشد',
        'data'  => []
    ];

    protected $notFoundComment = [
        'status'    => 'error',
        'massage'   => 'نظر مورد نظر یافت نشد',
        'data'  => []
    ];

    /**
     * 
     * Store post comment
     * 
     */
    public function store(CommentStore $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json($this->userNotAuth, 203);
            die;
        }

        $post = Post::find($request->post_id);
        if (!$post) {
            return response()->json($this->notFoundPost, 404);
            die;
        }


        $comment = new Comment;
        $comment->content = $request->content;
        $comment->post_id = $request->post_id;
        $comment->user_id = $user->id;
        $comment->save();

        $data = [
            'status'    => 'success',
            'massage'   => 'کامنت شما با موفقیت ثبت شد',
            'data'      => [
                'post'      => $post,
                'comment'   => $comment
            ]
        ];
        return response()->json($data, 200);
    }

    public function likeComment($comment_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json($this->userNotAuth, 203);
            die;
        }

        $comment = Comment::find($comment_id);
        if (!$comment) {
            return response()->json($this->notFoundComment, 404);
            die;
        }

        $comment->like = ++$comment->like;
        $comment->save();

        $data = [
            'status'    => 'success',
            'massage'   => 'شما این کامنت را پسندیدید',
            'data'      => [
                'comment'   => $comment
            ]
        ];
        return response()->json($data, 200);
    }
}
