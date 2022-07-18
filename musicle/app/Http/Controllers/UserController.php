<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
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
                'login_id' => $user->login_id,
                'name' => $user->name,
            ];
        }
        return $response;
    }

    /**
     * ユーザープロフィール情報取得API
     *
     * @param integer $login_id
     */
    public function get_profile(string $login_id)
    {
        $user = User::where('login_id', $login_id)->first();

        $follows = Follow::where('followee_user_id', $user->id)->get();
        $followers = Follow::where('follower_user_id', $user->id)->get();

        $response = [
            'user_id' => $user->user_id,
            'name' => $user->name,
            'image_path' => $user->image_path,
            'follow_count' => count($follows),
            'follower_count' => count($followers),
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
