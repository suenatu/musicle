<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Request;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * ユーザー一覧取得API（あとで消す）
     */
    public function index()
    {
        $users = User::all();

        $response = [];
        foreach($users as $user) {
            $response[] =[
                'id' => $user->id,
                'name' => $user->name,
            ];
        }
        return $response;
    }

    /**
     * ユーザープロフィール情報取得API
     *
     * @param integer $user_id
     */
    public function get_profile(int $user_id)
    {
        $user = User::find($user_id);

        $response = [
            'name' => $user->name,
            'image_path' => $user->image_path
        ];

        return $response;
    }

    /**
     * ログインユーザープロフィール情報取得API
     */
    public function get_my_profile()
    {
        $user = Auth::user();

        $response = [
            'name' => $user->name,
            'image_path' => $user->image_path
        ];

        return $response;
    }
}
