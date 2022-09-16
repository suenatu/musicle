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
        $room = Room::get_room_by_room_no($request->room_no);

        // ユーザーがルームに属するかチェック
        $is_room_user = Room::is_room_user($room->id, auth()->user()->id);
        if (!$is_room_user) {
            // TODO: レスポンスを決める
            return;
        }

        $messages = Message::where(['room_id' => $room->id])
            ->with('user')->get();
        return [
            'user_id' => auth()->user()->id,
            'messages' => $messages
        ];
    }

    public function send_message(Request $request)
    {
        $room = Room::get_room_by_room_no($request->room_no);
        $room->message_received_at = date('Y-m-d H:i:s');
        $room->save();
        $user = User::find(auth()->user()->id);
        $message = $user->messages()->create([
            'room_id' => $room->id,
            'message' => $request->message
        ]);

        event(new MessageSent($user, $message, $room));

        return ['status' => 'Message Sent!'];
    }
}
