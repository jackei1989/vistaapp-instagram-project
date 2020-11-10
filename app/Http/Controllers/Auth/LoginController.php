<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthUserLogin;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
        // method for user login
        public function login(AuthUserLogin $request)
        {
            // validate the request data
            $valid_data = $request->validated();
            
            $authUser = Auth::attempt([
                'user_name' => $valid_data['user_name'],
                'password' => $valid_data['password']
            ]);
            
            // check the user existent
            if(!$authUser) {

                $data = [
                    'status'    => 'error',
                    'response'  => [
                        'massage'   => 'کاربر با چنین مشخصات یافت نشد!',
                    ]                   
                ];
                return response()->json($data, 203);

                die;
            }
    
            // create user access token by passport
            $user = Auth::user();
            $userToken = $user->createToken('accessToken')->accessToken;
    
            $data =  [
                'status'    => 'success',
                'response'  => [
                    'user'          => $user,
                    'accessToken'   => $userToken
                ]
            ];
            return response()->json($data, 200);      
        }
}
