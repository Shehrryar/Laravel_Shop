<?php
namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class adminChatController extends Controller
{
    public function index()
    {
        $all_chats_array = [];
        $users = User::all(); // Fetch all users without ordering them.
        foreach ($users as $user) {
            $user_id = $user->id;
            $getchat = DB::table('messages')
                ->where(function ($query) use ($user_id) {
                    $query->where('sender_id', Auth::id())
                        ->where('receiver_id', $user_id);
                })
                ->orWhere(function ($query) use ($user_id) {
                    $query->where('sender_id', $user_id)
                        ->where('receiver_id', Auth::id());
                })
                ->orderBy('created_at', 'asc') // Ensure chats are ordered by creation time.
                ->get();

            // Convert the collection to an array if it's not empty.
            if ($getchat->isNotEmpty()) {
                $all_chats_array[$user_id] = $getchat->toArray();
                $all_chats_array[$user_id]['user_detail']['name'] = $user->name;
                $all_chats_array[$user_id]['user_detail']['email'] = $user->email;
                $all_chats_array[$user_id]['user_detail']['phone'] = $user->phone;
                $all_chats_array[$user_id]['user_detail']['status'] = $user->status;
            }
        }
        $data = [
            'allchatstoadmin' => $all_chats_array,
        ];
        return view('admin.chats.list', $data);
    }
}