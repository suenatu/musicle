<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;

use App\Models\Room;
use App\Models\User;
use App\Models\Message;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('message');
    }

    public function fetchMessages(Request $request)
    {
        $messages = Message::where(['room_id' => $request->room_id])
            ->with('user')->get();
        return [
            'user_id' => auth()->user()->id,
            'messages' => $messages
        ];
    }

    public function sendMessage(Request $request)
    {
        $room = Room::find($request->room_id);
        $user = User::find(auth()->user()->id);
        $message = $user->messages()->create([
            'room_id' => $request->room_id,
            'message' => $request->message
        ]);

        event(new MessageSent($user, $message));

        return ['status' => 'Message Sent!'];
    }
}
