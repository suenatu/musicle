<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    /**
     * ログインIDからユーザー情報を取得
     * （TODO: プロフィールテーブルとかくっつけたい）
     */
    public static function get_user_by_login_id(string $login_id)
    {
        return self::where('login_id', $login_id)->first();
    }
}
