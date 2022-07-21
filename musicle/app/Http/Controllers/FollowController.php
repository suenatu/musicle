<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Follow;

class FollowController extends Controller
{
    /**
     * フォローAPI
     */
    public function follow(Request $request)
    {
        try {
            $target_user_id = $request->input('user_id');
            Follow::follow(auth()->user()->id, $target_user_id);
            return response()->json(
                [
                    'follower_count' => Follow::get_follower_count($target_user_id),
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
     * リムーブAPI
     */
    public function remove(Request $request)
    {
        try {
            $target_user_id = $request->input('user_id');
            Follow::remove(auth()->user()->id, $target_user_id);
            return response()->json(
                [
                    'follower_count' => Follow::get_follower_count($target_user_id),
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
}
