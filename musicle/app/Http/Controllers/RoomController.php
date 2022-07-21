<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * ルーム一覧取得API
     */
    public function get_rooms()
    {
        $room_user_list = DB::table('room_user')
            ->join('rooms', 'room_user.room_id', '=', 'rooms.id')
            ->join('users', 'users.id', '=', 'room_user.user_id')
            ->where('room_user.user_id', '<>',auth()->user()->id)
            ->where('rooms.type', Room::TYPE_ONE)
            ->get();

        $response = [];
        foreach ($room_user_list as $room_user) {
            $response[] = [
                'name' => $room_user->name,
                'login_id' => $room_user->login_id,
                'image_path' => $room_user->image_path,
                'room_id' => $room_user->room_id,
            ];
        }
        return response()->json($response, Response::HTTP_OK);
    }
}
