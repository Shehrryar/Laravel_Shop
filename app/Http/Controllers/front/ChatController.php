<?php

namespace App\Http\Controllers\Front;

use App\Events\ChatMessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private function getAdminId()
    {
        return User::where('role', 2)
            ->orderBy('id', 'asc')
            ->value('id');
    }

    public function renderchatbox(Request $request)
    {
        $userId = Auth::id();
        $adminId = $this->getAdminId();

        if (!$adminId) {
            return response()->json([
                'status' => false,
                'message' => 'Admin user was not found.',
                'sender_id' => $userId,
                'receiver_id' => null,
                'chat_message' => [],
            ], 404);
        }

        $messages = Message::where(function ($query) use ($userId, $adminId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $adminId);
            })
            ->orWhere(function ($query) use ($userId, $adminId) {
                $query->where('sender_id', $adminId)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'message_content' => $message->message_content,
                    'read_status' => $message->read_status,
                    'created_at' => $message->created_at?->format('Y-m-d H:i'),
                ];
            });

        return response()->json([
            'status' => true,
            'sender_id' => $userId,
            'receiver_id' => $adminId,
            'chat_message' => $messages,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message_content' => 'required|string|max:1000',
        ]);

        $adminId = $this->getAdminId();

        if (!$adminId) {
            return response()->json([
                'status' => false,
                'message' => 'Admin user was not found.',
            ], 404);
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $adminId,
            'message_content' => $request->message_content,
            'read_status' => 0,
        ]);

        broadcast(new ChatMessageSent($message));

        return response()->json([
            'id' => $message->id,
            'sender_id' => $message->sender_id,
            'receiver_id' => $message->receiver_id,
            'message_content' => $message->message_content,
            'read_status' => $message->read_status,
            'created_at' => $message->created_at?->format('Y-m-d H:i'),
        ]);
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
            ->orderBy('created_at', 'asc')
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