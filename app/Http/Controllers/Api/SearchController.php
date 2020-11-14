<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserArchive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SearchController extends Controller
{
    /**
     * 
     * Mehtod For Search user by user name
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

    /**
     * 
     * Mehthod for search in user archive
     * 
     */
    public function searchInArchive(Request $request)
    {
        $item = $request->input('q');
        $posts = UserArchive::where('content', 'LIKE', '%' . $item . '%')->get();

        if (!count($posts) > 0) {
            $data = [
                'status'    => 'error',
                'massage'      => 'هیج پستی یافت نشد',
                'response'  => []
            ];
            return response()->json($data, 404);
            die;
        }

        $data = [
            'status'    => 'success',
            'massage'      => 'پست یافت شد',
            'response'  => [
                'posts'      => $posts,
            ]
        ];
        return response()->json($data, 200);
    }
}
