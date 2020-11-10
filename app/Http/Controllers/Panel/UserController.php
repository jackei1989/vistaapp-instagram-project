<?php

namespace App\Http\Controllers\Panel;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserProfile;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        $user = Auth::user();
        
        $data = [
            'status'    => 'success',
                'response'  => [
                    'user'   => $user
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

        if(!$user) {

            $data = [
                'status'    => 'error',
                'response'  => [
                    'massage'   => 'کاربر مورد نظر شما یافت نشد!',
                ]
            ];
            return response()->json($data, 404);

            die;
        }

        $data = [
            'status'    => 'success',
            'response'  => [
                'user'  => $user,
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

        if(!$user) {

            $data = [
                'status'    => 'error',
                'response'  => [
                    'massage'   => 'کاربر مورد نظر شما یافت نشد!',
                ]
            ];
            return response()->json($data, 404);

            die;
        }

        if($user->user_name != Auth::user()->user_name) {
            
            $data = [
                'status'    => 'error',
                'response'  => [
                    'massage'   => 'شما دسترسی لازم برای ویرایش اطلاعات را ندارید',
                ]
            ];

            return response()->json($data, 203);
            die;
        }

        $data = [
            'status'    => 'success',
            'response'  => [
                'user'  => $user,
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
    public function update(Request $request, $user_name)
    {

        $user = User::where('user_name', $user_name)->first();
        
        if(! $user) {
            $data = [
                'status'    => 'error',
                'response'  => [
                    'massage'   => 'کاربر مورد نظر یافت نشد',
                ]
            ];

            return response()->json($data, 203);
            die;
        }

        if($user->user_name != Auth::user()->user_name) {
            
            $data = [
                'status'    => 'error',
                'response'  => [
                    'massage'   => 'شما دسترسی لازم برای ویرایش اطلاعات را ندارید',
                ]
            ];

            return response()->json($data, 203);
            die;
        }
        
        $user->user_name = $request->userName;
        $user->bio = $request->bio;
        $user->web_site = $request->web_site;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->save();
       
        $data = [
            'status'    => 'success',
            'response'  => [
                'user'  => $user,
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

        if(! $user) {
            $data = [
                'status'    => 'error',
                'response'  => [
                    'massage'   => 'کاربر مورد نظر یافت نشد',
                ]
            ];

            return response()->json($data, 203);
            die;
        }

        $user->delete();

        $data = [
            'status'    => 'success',
            'response'  => [
                'user'  => $user,
            ]
        ];
        return response()->json($data, 200);
    }
}
