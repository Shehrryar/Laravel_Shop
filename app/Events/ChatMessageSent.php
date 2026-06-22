<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->receiver_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        $sender = User::find($this->message->sender_id);
        $receiver = User::find($this->message->receiver_id);

        return [
            'message' => [
                'id' => $this->message->id,
                'sender_id' => $this->message->sender_id,
                'receiver_id' => $this->message->receiver_id,
                'message_content' => $this->message->message_content,
                'read_status' => $this->message->read_status,
                'created_at' => $this->message->created_at?->format('Y-m-d H:i'),

                'sender_name' => $sender?->name ?? 'Customer',
                'sender_email' => $sender?->email ?? '',
                'sender_phone' => $sender?->phone ?? '',

                'receiver_name' => $receiver?->name ?? '',
                'receiver_email' => $receiver?->email ?? '',
            ],
        ];
    }
}