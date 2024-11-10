<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ChatController extends Controller
{

    public function renderchatbox(Request $request)
    {
        $adminId = DB::table('users')
            ->where('role', 2)
            ->where('name', 'admin')
            ->value('id');
        $getchat = DB::table('messages')
            ->where(function ($query) use ($adminId) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $adminId);
            })
            ->orWhere(function ($query) use ($adminId) {
                $query->where('sender_id', $adminId)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc') // Optional: Order by timestamp if needed
            ->get();

        $data = [];
        $data['sender_id'] = Auth::id();
        $data['receiver_id'] = $adminId;
        $data['chat_message'] = $getchat;
        return response()->json($data);

    }
    public function sendMessage(Request $request)
    {
        $adminId = DB::table('users')
            ->where('role', 2)
            ->where('name', 'admin')
            ->value('id');

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $adminId,
            'message_content' => $request->message_content,
        ]);

        return response()->json($message);
    }

    public function fetchMessages($receiverId)
    {
        $messages = Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $receiverId);
        })
            ->orWhere(function ($query) use ($receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    public function markAsRead($receiverId)
    {
        Message::where('receiver_id', Auth::id())
            ->where('sender_id', $receiverId)
            ->update(['read_status' => true]);

        return response()->json(['status' => 'success']);
    }

}
