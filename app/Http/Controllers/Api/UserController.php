<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserProfile;

class UserController extends Controller
{
    protected $userNotAuth = [
        'status'    => 'error',
        'massage'   => 'هویت کاربر نا مشخص است',
        'data'  => []
    ];

    protected $notFoundUser = [
        'status'    => 'error',
        'massage'   => 'کاربر مورد نظر شما یافت نشد!',
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

        $data = [
            'status'    => 'success',
            'massage'   => '',
            'data'  => [
                'user'      => $user,
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
    public function store(Request $request)
    {
        //
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
            return response()->json($this->notFoundUser, 404);
            die;
        }

        $data = [
            'status'    => 'success',
            'massage'   =>  'کاربر یافت شد',
            'data'  => [
                'user'      => $user,
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
    public function edit($user_name)
    {

        $user = User::where('user_name', $user_name)->first();

        if (!$user) {
            return response()->json($this->notFoundUser, 404);
            die;
        }

        $data = [
            'status'    => 'success',
            'massage'   =>  '',
            'data'  => [
                'user'      => $user,
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
    public function update(UpdateUserProfile $request, $user_name)
    {

        $user = User::where('user_name', $user_name)->first();

        if (!$user) {
            return response()->json($this->notFoundUser, 404);
            die;
        }

        if ($user->id != Auth::user()->id) {
            return response()->json($this->accessDeny, 203);
            die;
        }

        $user->user_name = $request->userName ? $request->userName : $user->user_name;
        $user->password = $request->password ? Hash::make($request->userName) : $user->user_name;
        $user->bio = $request->bio ? $request->bio : null;
        $user->web_site = $request->web_site ? $request->web_site : null;
        $user->email = $request->email ? $request->email : null;
        $user->phone = $request->phone ? $request->phone : null;
        $user->gender = $request->gender ? $request->gender : null;
        $user->save();

        $data = [
            'status'    => 'success',
            'massage'   => 'پروفایل شما با موفقیت ویرایش شد',
            'data'  => [
                'user'      => $user,
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
    public function destroy($user_name)
    {
        $user = User::where('user_name', $user_name)->first();

        if (!$user) {
            return response()->json($this->notFoundUser, 404);
            die;
        }

        if ($user->id != Auth::user()->id) {
            return response()->json($this->accessDeny, 203);
            die;
        }

        $user->delete();

        $data = [
            'status'    => 'success',
            'massage'   =>  'حساب کاربری شما با موفقیت حذف شد',
            'data'  => [
                'user'      => $user,
            ]
        ];
        return response()->json($data, 200);
    }

    /**
     * 
     * Method for find user posts
     * 
     */
    public function postsUser($user_name)
    {
        $user = User::where('user_name', $user_name)->first();

        if (!$user) {
            return response()->json($this->notFoundUser, 404);
            die;
        }

        $data = [
            'status'    => 'success',
            'massage'   =>  '',
            'data'  => [
                'posts'  => $user->posts,
            ]
        ];
        return response()->json($data, 200);
    }

    /**
     * 
     * Mehtod for followe other users
     * 
     */
    public function following($user_name)
    {
        $follower_user = Auth::user();
        $following_user = User::where('user_name', $user_name)->first();

        if (!$following_user) {
            return response()->json($this->notFoundUser, 404);
            die;
        }

        $isExistence = Follower::where('follower_id', $follower_user->id)->where('following_id', $following_user->id)->get();

        if (count($isExistence) > 0) {
            $data = [
                'status'    => 'error',
                'massage'   => 'را دنبال کرده اید ' . $following_user->user_name . ' شما قبلا ',
                'data'      => []
            ];
            return response()->json($data, 203);
            die;
        }

        $followers = new Follower;
        $followers->follower_id = $follower_user->id;
        $followers->following_id = $following_user->id;
        $followers->save();

        $data = [
            'status'    => 'success',
            'massage'   =>  'را دنبال میکنید ' . $following_user->user_name . ' شما ',
            'data'      => [
                'user'              => $follower_user,
                'following user'    => $following_user
            ]
        ];
        return response()->json($data, 200);
    }
}
