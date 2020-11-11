<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthUserRegister;

class RegisterController extends Controller
{
    /**
     * 
     * Register Handler
     * 
     */
    public function register(AuthUserRegister $request)
    {
        // validate the request data
        $valid_data = $request->validated();

        // create user
        $user = new User;
        $user->user_name =  $valid_data['user_name'];
        $user->password  =  Hash::make($valid_data['password']);
        $user->save();

        // create user access token by passport
        $userToken = $user->createToken('accessToken')->accessToken;

        $data = [
            'status'    => 'success',
            'massage'   =>  'ثبت نام شما موفقیت آمیز بود',
            'data'  => [
                'user'          => $user,
                'accessToken'   => $userToken,
            ]
        ];
        return response()->json($data, 200);
    }
}
