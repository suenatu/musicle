<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * ルーム一覧取得API
     */
    public function get_rooms()
    {
        // ルーム一覧取得
        $room_users = Room::get_rooms(auth()->user()->id);
        $response = [];
        foreach ($room_users as $room_user) {
            $response[] = [
                'name' => $room_user->name,
                'login_id' => $room_user->login_id,
                'image_path' => $room_user->image_path,
                'room_no' => $room_user->room_id,
            ];
        }
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * ルームID取得API
     */
    public function get_room(Request $request)
    {
        // ルームIDを取得
        $room_no = Room::get_one_room_id_by_user_id(auth()->user()->id, $request->user_id);
        // ルームIDを返却
        if (!is_null($room_no)) {
            return response()->json(['room_no' => $room_no], Response::HTTP_OK);
        }

        // ルームを作成
        $room_no = uniqid(bin2hex(random_bytes(1)));
        $room = Room::create(['no' => $room_no, 'type' => Room::TYPE_ONE]);
        // 中間テーブルにデータを作成
        $room->users()->attach(auth()->user()->id);
        $room->users()->attach($request->user_id);
        // ルームIDを返却
        return response()->json(['room_no' => $room->no], Response::HTTP_OK);
    }

    /**
     * ルームのユーザーデータ取得API
     */
    public function get_user_data_in_message(Request $request)
    {
        $users = Room::where('no', $request->room_no)->first()->users;
        $response = [];
        foreach ($users as $user) {
            $response[] = [
                'id' => $user->id,
                'name' => $user->name,
                'login_id' => $user->login_id,
                'image_path' => $user->image_path,
            ];
        }
        return response()->json($response, Response::HTTP_OK);
    }
}
