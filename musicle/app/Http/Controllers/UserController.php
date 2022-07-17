<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Psr7\Request;

class UserController extends Controller
{
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

    public function get_profile($user_id)
    {
        $user = User::find($user_id);

        $response = [
            'name' => $user->name,
            'image_path' => $user->image_path
        ];

        return $response;
    }
}
