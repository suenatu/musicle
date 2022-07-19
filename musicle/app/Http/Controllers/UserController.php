<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Follow;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * ユーザー一覧取得API（あとで消す）
     */
    public function index()
    {
        try {
            $users = User::all();

            $response = [];
            foreach ($users as $user) {
                $response[] = [
                    'id' => $user->id,
                    'login_id' => $user->login_id,
                    'name' => $user->name,
                ];
            }
            return response()->json(
                $response,
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => ['code' => '', 'message' => $th->getMessage()]],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * ユーザープロフィール情報取得API
     */
    public function get_profile(string $login_id)
    {
        try {
            $user = User::get_user_by_login_id($login_id);

            if (is_null($user)) {
                return response()->json(
                    ['is_user' => false],
                    Response::HTTP_OK
                );
            }

            return response()->json(
                [
                    'is_user' => true,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'image_path' => $user->image_path,
                    'follow_count' => Follow::get_follow_count($user->id),
                    'follower_count' => Follow::get_follower_count($user->id),
                    'is_follow' => Follow::is_follow(auth()->user()->id, $user->id),
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $th) {
            return response()->json(
                ['error' => ['code' => '', 'message' => $th->getMessage()]],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * ログインユーザープロフィール情報取得API
     */
    public function get_my_profile()
    {
        try {
            $user = Auth::user();

            $response = [
                'name' => $user->name,
                'image_path' => $user->image_path
            ];
            return response()->json(
                $response,
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => ['code' => '', 'message' => $th->getMessage()]],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
