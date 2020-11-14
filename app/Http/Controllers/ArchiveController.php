<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\UserArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArchiveController extends Controller
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

    /**
     * 
     * Save post on user archive
     * 
     */
    public function save($post_id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json($this->userNotAuth, 203);
            die;
        }

        $post = Post::find($post_id);
        if (!$post) {
            return response()->json($this->notFoundPost, 404);
            die;
        }

        $userArchive = new UserArchive;
        $userArchive->user_id = $user->id;
        $userArchive->image = $post->image;
        $userArchive->content = $post->content;
        $userArchive->save();

        $data = [
            'status'    => 'success',
            'massage'   => 'پست با موفقیت ذخیره شد',
            'data'      => [
                'post'      => $post,
            ]
        ];
        return response()->json($data, 200);
    }

}
