<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Room extends Model
{
    protected $fillable = ['no', 'type', 'name'];

    const TYPE_ONE = 1;
    const TYPE_GROUP = 2;

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public static function get_room_id_by_room_no(string $no)
    {
        $room = self::where('no', $no)->first();
        if (!is_null($room)) {
            return $room->id;
        }
        return null;
    }

    /**
     * ルーム一覧取得
     */
    public static function get_rooms(int $user_id)
    {
        $room_user = DB::table('room_user')
            ->select([
                'users.name',
                'users.login_id',
                'users.image_path',
                'rooms.no'
            ])
            ->join('users', 'room_user.user_id', '=', 'users.id')
            ->join('rooms', 'rooms.id', '=', 'room_user.room_id')
            ->whereIn(
                'room_id',
                function ($query) use ($user_id) {
                    $query->select('rooms.id')
                        ->from('rooms')
                        ->join('room_user', 'rooms.id', '=', 'room_user.room_id')
                        ->where('rooms.type', self::TYPE_ONE)
                        ->where('room_user.user_id', $user_id);
                }
            )
            ->where('room_user.user_id', '<>', $user_id)
            ->get();
        return $room_user;
    }

    /**
     * ルームID取得
     */
    public static function get_one_room_id_by_user_id(int $user_id, int $target_user_id)
    {
        $room_user = DB::table('room_user')
            ->join('rooms', 'rooms.id', '=', 'room_user.room_id')
            ->whereIn(
                'room_id',
                function ($query) use ($user_id) {
                    $query->select('rooms.id')
                        ->from('rooms')
                        ->join('room_user', 'rooms.id', '=', 'room_user.room_id')
                        ->where('rooms.type', self::TYPE_ONE)
                        ->where('room_user.user_id', $user_id);
                }
            )
            ->where('room_user.user_id', '<>', $user_id)
            ->where('room_user.user_id', $target_user_id)
            ->first();

        if (!is_null($room_user)) {
            return $room_user->no;
        }
        return null;
    }
}
