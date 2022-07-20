<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Models\User;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('post');
    }

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        // $user = Auth::user();
        $user = User::find(auth()->user()->id);

        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);

        event(new MessageSent($user, $message));

        return ['status' => 'Message Sent!'];
    }
}
