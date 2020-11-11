<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserLogin;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * 
     * Login handler 
     * 
     */
    public function login(AuthUserLogin $request)
    {
        // validate the request data
        $valid_data = $request->validated();

        $authUser = Auth::attempt([
            'user_name' => $valid_data['user_name'],
            'password' => $valid_data['password']
        ]);

        // check the user existent
        if (!$authUser) {
            $data = [
                'status'    => 'error',
                'massage'   => 'کاربر با چنین مشخصات یافت نشد!',
                'data'  => []
            ];
            return response()->json($data, 203);
            die;
        }

        // create user access token by passport
        $user = Auth::user();
        $userToken = $user->createToken('accessToken')->accessToken;

        $data =  [
            'status'    => 'success',
            'massage'   =>  'شما با موفقیت وارد شدید',
            'data'  => [
                'user'          => $user,
                'accessToken'   => $userToken
            ]
        ];
        return response()->json($data, 200);
    }
}
