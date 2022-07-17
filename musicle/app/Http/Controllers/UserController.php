<?php

namespace App\Http\Controllers;

use App\Models\User;

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
}
