<?php

namespace App\Http\Controllers\admin;

use App\Events\ChatMessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminChatController extends Controller
{
    private function adminUser()
    {
        return Auth::guard('admin')->user() ?? Auth::user();
    }

    private function adminId()
    {
        return Auth::guard('admin')->id() ?? Auth::id();
    }

    private function isMainAdmin(): bool
    {
        $admin = $this->adminUser();

        return $admin && (int) $admin->role === 2;
    }

    private function isVendor(): bool
    {
        $admin = $this->adminUser();

        return $admin && (int) $admin->role === 3;
    }

    private function vendorStoreId()
    {
        return $this->adminUser()?->store_id;
    }

    private function vendorCustomerIds(): array
    {
        if (!$this->isVendor()) {
            return [];
        }

        if (empty($this->vendorStoreId())) {
            return [];
        }

        return DB::table('orders')
            ->join('orders_items', 'orders.id', '=', 'orders_items.order_id')
            ->join('products', 'orders_items.product_id', '=', 'products.id')
            ->where('products.store_id', $this->vendorStoreId())
            ->whereNotNull('orders.user_id')
            ->distinct()
            ->pluck('orders.user_id')
            ->map(fn ($id) => (int) $id)
            ->toArray();
    }

    private function ensureVendorCanChatWithCustomer($customerId): void
    {
        if (!$this->isVendor()) {
            return;
        }

        if (empty($this->vendorStoreId())) {
            abort(403, 'Vendor account is not connected with any store.');
        }

        $allowedCustomerIds = $this->vendorCustomerIds();

        if (!in_array((int) $customerId, $allowedCustomerIds, true)) {
            abort(403, 'You cannot chat with another vendor customer.');
        }

        $customerExists = User::where('id', $customerId)
            ->where('role', 1)
            ->exists();

        if (!$customerExists) {
            abort(403, 'Vendor can chat only with customers.');
        }
    }

    public function index(Request $request)
    {
        $adminId = $this->adminId();
        $keyword = $request->keyword;

        $usersQuery = User::query()
            ->where('role', 1);

        /*
        |--------------------------------------------------------------------------
        | Vendor Chat Filter
        |--------------------------------------------------------------------------
        | Vendor can see only customers who bought products from vendor store.
        */
        $allowedCustomerIds = [];

        if ($this->isVendor()) {
            if (empty($this->vendorStoreId())) {
                abort(403, 'Vendor account is not connected with any store.');
            }

            $allowedCustomerIds = $this->vendorCustomerIds();

            $usersQuery->whereIn('id', $allowedCustomerIds);
        }

        if (!empty($keyword)) {
            $usersQuery->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%");
            });
        }

        $users = $usersQuery->orderBy('name', 'asc')->get();

        $chatUsers = $users->map(function ($user) use ($adminId) {
            $messages = $this->getConversationMessages($adminId, $user->id);

            $latestMessage = $messages->last();

            $unreadCount = Message::where('sender_id', $user->id)
                ->where('receiver_id', $adminId)
                ->where('read_status', 0)
                ->count();

            return (object) [
                'user' => $user,
                'messages' => $messages,
                'latest_message' => $latestMessage?->message_content ?? 'No message yet',
                'latest_time' => $latestMessage?->created_at?->format('Y-m-d H:i') ?? '',
                'latest_sort_time' => $latestMessage?->created_at?->timestamp ?? 0,
                'unread_count' => $unreadCount,
            ];
        })
        ->sortByDesc('latest_sort_time')
        ->values();

        return view('admin.chats.list', [
            'chatUsers' => $chatUsers,
            'adminId' => $adminId,
            'isVendor' => $this->isVendor(),
            'allowedCustomerIds' => $allowedCustomerIds,
        ]);
    }

    public function chatDisplayBox(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer',
        ]);

        $adminId = $this->adminId();
        $userId = (int) $request->receiver_id;

        $this->ensureVendorCanChatWithCustomer($userId);

        $messages = $this->getConversationMessages($adminId, $userId);

        Message::where('sender_id', $userId)
            ->where('receiver_id', $adminId)
            ->update(['read_status' => 1]);

        return response()->json([
            'status' => true,
            'specificChat' => $messages->map(function ($message) {
                return $this->formatMessage($message);
            }),
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiverId' => 'required|integer',
            'message_content' => 'required|string|max:1000',
        ]);

        $adminId = $this->adminId();
        $receiverId = (int) $request->receiverId;

        $this->ensureVendorCanChatWithCustomer($receiverId);

        $message = Message::create([
            'sender_id' => $adminId,
            'receiver_id' => $receiverId,
            'message_content' => $request->message_content,
            'read_status' => 0,
        ]);

        broadcast(new ChatMessageSent($message));

        return response()->json($this->formatMessage($message));
    }

    private function getConversationMessages($adminId, $userId)
    {
        return Message::where(function ($query) use ($adminId, $userId) {
                $query->where('sender_id', $adminId)
                    ->where('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($adminId, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $adminId);
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function formatMessage($message)
    {
        return [
            'id' => $message->id,
            'sender_id' => $message->sender_id,
            'receiver_id' => $message->receiver_id,
            'message_content' => $message->message_content,
            'read_status' => $message->read_status,
            'created_at' => $message->created_at?->format('Y-m-d H:i'),
        ];
    }

    public function checkSocketMessage(Request $request)
    {
        if (!$this->isMainAdmin()) {
            abort(403, 'Only super admin can access socket testing page.');
        }

        return view('admin.chats.create');
    }

    public function markAsRead($senderId)
    {
        $senderId = (int) $senderId;

        $this->ensureVendorCanChatWithCustomer($senderId);

        $adminId = $this->adminId();

        Message::where('sender_id', $senderId)
            ->where('receiver_id', $adminId)
            ->update(['read_status' => 1]);

        return response()->json([
            'status' => true,
            'message' => 'Messages marked as read.',
        ]);
    }
}