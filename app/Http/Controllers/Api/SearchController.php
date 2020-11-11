<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SearchController extends Controller
{
    /**
     * 
     * Mehtod For Search Handler
     */
    public function search(Request $request)
    {
        $item = $request->input('q');
        $user = User::where('user_name', 'LIKE', '%' . $item . '%')->get();

        if (!count($user) > 0) {
            $data = [
                'status'    => 'error',
                'response'  => [
                    'massage'      => 'هیج کاربری یافت نشد',
                ]
            ];
            return response()->json($data, 404);
            die;
        }

        $data = [
            'status'    => 'success',
            'response'  => [
                'user'      => $user,
            ]
        ];
        return response()->json($data, 200);
    }
}
