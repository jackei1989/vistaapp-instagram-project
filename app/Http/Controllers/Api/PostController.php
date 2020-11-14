<?php

namespace App\Http\Controllers\Api;

use App\Classes\Helpers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStore;

class PostController extends Controller
{

    protected $notFoundPost = [
        'status'    => 'error',
        'massage'   => 'پست مورد نظر یافت نشد',
        'data'  => []
    ];

    protected $userNotAuth = [
        'status'    => 'error',
        'massage'   => 'هویت کاربر نا مشخص است',
        'data'  => []
    ];

    protected $accessDeny = [
        'status'    => 'error',
        'massage'   => 'شما دسترسی لازم را برای انجام این کار ندارید!',
        'data'  => []
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();

        if (!$user) {
            return response()->json($this->userNotAuth, 203);
            die;
        }

        $userPosts = Post::where('user_id', $user->id)->get();

        $data = [
            'status'    => 'success',
            'massage'   =>  $user->user_name . ' تمام پستهای شما',
            'data'  => [
                'posts'   => $userPosts
            ]
        ];
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStore $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json($this->userNotAuth, 203);
            die;
        }

        $post = new Post;
        if ($image = $request->file('image')) {
            $name = $image->getClientOriginalName();
            $image->move('images', $name);

            $post->image = $name;
        }

        $post->content = $request->content ? $request->content : null;
        $post->user_id = $user->id;
        $post->save();

        $data = [
            'status'    => 'success',
            'massage'   =>  'پست شما با موفقیت ثبت شد',
            'data'  => [
                'posts'   => $post
            ]
        ];
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_name)
    {
        $user = User::where('user_name', $user_name)->first();

        if (!$user) {
            $data = [
                'status'    => 'error',
                'massage'   => 'کاربر مورد نظر شما یافت نشد!',
                'data'  => []
            ];

            return response()->json($data, 404);
            die;
        }

        $userPosts = Post::where('user_id', $user->id)->get();

        $data = [
            'status'    => 'success',
            'massage'   =>  $user->user_name . ' تمام پستهای',
            'data'  => [
                'posts'   => $userPosts
            ]
        ];
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        $user = Auth::user();
        $post = Post::where('user_id', $user->id)->where('id', $post_id)->first();

        if (!$user) {
            return response()->json($this->userNotAuth, 203);
            die;
        }

        if ($user->id != Auth::user()->id) {
            return response()->json($this->accessDeny, 203);
            die;
        }

        if (!$post) {
            return response()->json($this->notFoundPost, 404);
            die;
        }

        $data = [
            'status'    => 'success',
            'massage'   => 'پست یافت شده',
            'data'  => [
                'posts'   => $post
            ]
        ];
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post_id)
    {
        $user = Auth::user();
        $post = Post::where('user_id', $user->id)->where('id', $post_id)->first();

        if (!$user) {
            return response()->json($this->userNotAuth, 203);
            die;
        }

        if ($user->id != Auth::user()->id) {
            return response()->json($this->accessDeny, 203);
            die;
        }

        if (!$post) {
            return response()->json($this->notFoundPost, 404);
            die;
        }

        $post->content = $request->content ? $request->content : null;
        $post->user_id = $user->id;
        $post->save();

        $data = [
            'status'    => 'success',
            'massage'   => 'پست با موفقیت ویرایش شد',
            'data'  => [
                'posts'   => $post
            ]
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($post_id)
    {
        $user = Auth::user();
        $post = Post::where('user_id', $user->id)->where('id', $post_id)->first();

        if (!$user) {
            return response()->json($this->userNotAuth, 203);
            die;
        }

        if ($user->id != Auth::user()->id) {
            return response()->json($this->accessDeny, 203);
            die;
        }

        if (!$post) {
            return response()->json($this->notFoundPost, 404);
            die;
        }

        $post->delete();

        $data = [
            'status'    => 'success',
            'massage'   => 'پست با موفقیت حذف شد',
            'data'  => [
                'user'      => $post,
            ]
        ];
        return response()->json($data, 200);
    }

    /**
     * 
     * Method for Like Posts
     * 
     */
    public function likePost($post_id)
    {
        $post = Post::find($post_id);
        $user = Auth::user();

        if (!$user) {
            return response()->json($this->userNotAuth, 203);
            die;
        }

        if (!$post) {
            return response()->json($this->notFoundPost, 404);
            die;
        }

        $post->like = ++$post->like;
        $post->save();

        $data = [
            'status'    => 'success',
            'massage'   => 'شما این پست را پسندیدید',
            'data'  => [
                'post'          => $post
            ]
        ];
        return response()->json($data, 200);
    }

    /**
     * 
     * Sort Post By Most Like
     * 
     */
    public function sortPostByMostLike()
    {
        $posts = Post::orderBy('like', 'DESC')->get();

        $data = [
            'status'    => 'success',
            'massage'   => 'نمایش پستها بر اساس بیشترین لایک',
            'data'  => [
                'post'          => $posts
            ]
        ];
        return response()->json($data, 200);
    }
}
