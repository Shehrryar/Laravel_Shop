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
        $all_chats_array = array();
        $users = User::latest()->get();
        foreach ($users as $key => $user) {
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
                ->orderBy('created_at', 'asc') // Optional: Order by timestamp if needed
                ->get();

                $all_chats_array[$user_id] = $getchat;
        }
        $data = [];
        $data['allchatstoadmin'] = $all_chats_array;
        return view('admin.chats.list', $data);
    }
}
