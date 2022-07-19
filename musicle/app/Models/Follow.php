<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follow extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * フォロー状態取得
     */
    public static function is_follow(int $user_id, int $target_user_id): bool
    {
        $follow = self::where(['user_id' => $user_id, 'target_user_id' => $target_user_id])->first();
        return isset($follow);
    }

    /**
     * フォロー一覧取得
     */
    public static function get_follows(int $user_id)
    {
        return self::where('user_id', $user_id)->get();
    }

    /**
     * フォロー数取得
     */
    public static function get_follow_count(int $user_id): int
    {
        return self::get_follows($user_id)->count();
    }

    /**
     * フォロー一覧取得
     */
    public static function get_followers(int $user_id)
    {
        return self::where('target_user_id', $user_id)->get();
    }

    /**
     * フォロワーー数取得
     */
    public static function get_follower_count(int $user_id): int
    {
        return self::get_followers($user_id)->count();
    }

    /**
     * フォロー
     */
    public static function follow(int $user_id, int $target_user_id)
    {
        $follow = new self;
        $follow->user_id = $user_id;
        $follow->target_user_id = $target_user_id;
        if ($follow->save()) {
            return true;
        }
        return false;
    }

    /**
     * フォロー解除
     */
    public static function remove(int $user_id, int $target_user_id)
    {
        $follow = self::where(['user_id' => $user_id, 'target_user_id' => $target_user_id])->first();
        if (isset($follow)) {
            return $follow->delete();
        }
        return false;
    }
}
