<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\MessageSent;

use App\Models\User;
use App\Models\Message;
use App\Models\Room;

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

    public function fetch_messages(Request $request)
    {
        $room_id = Room::get_room_id_by_room_no($request->room_no);
        $messages = Message::where(['room_id' => $room_id])
            ->with('user')->get();
        return [
            'user_id' => auth()->user()->id,
            'messages' => $messages
        ];
    }

    public function send_message(Request $request)
    {
        $room_id = Room::get_room_id_by_room_no($request->room_no);
        $user = User::find(auth()->user()->id);
        $message = $user->messages()->create([
            'room_id' => $room_id,
            'message' => $request->message
        ]);

        event(new MessageSent($user, $message));

        return ['status' => 'Message Sent!'];
    }
}
