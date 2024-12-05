<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::latest();
        if (!empty($request->get('keyword'))) {
            $user = $user->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $user = $user->paginate(10);
        return view('admin.users.list', ['users' => $user]);
    }

    public function create(Request $request)
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validater = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'phone' => 'required',
                'password' => 'required',
            ]
        );
        if ($validater->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->name);
            $user->status = $request->status;
            $user->save();
            $message = "User is added Successfully";
            session()->flash('success', $message);
            return response()->json(
                [
                    'status' => true,
                    'message' => $message
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validater->errors()
                ]
            );
        }
    }

    public function edit($userid, Request $request){
        $user_edit = User::find($userid);
        return view('admin.users.edit', compact('user_edit'));
    }

    public function update(Request $request, $user_id)
    {
        $user_edit = User::find($user_id);
        if(empty($user_edit))
        return response()->json([
             'status'=>false,
             'not found'=>ture,
             'message'=> 'User not found'
     ]);

        $validater = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|unique:users,email,'.$user_edit->id.',id',
                'phone' => 'required',
                'password' => 'required',
            ]
        );
        if ($validater->passes()) {
            $user_edit->name = $request->name;
            $user_edit->email = $request->email;
            $user_edit->phone = $request->phone;
            $user_edit->password = Hash::make($request->name);
            $user_edit->status = $request->status;
            $user_edit->save();
            $message = "User is Updated Successfully";
            session()->flash('success', $message);
            return response()->json(
                [
                    'status' => true,
                    'message' => $message
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validater->errors()
                ]
            );
        }
    }

    public function destroy($user_id, Request $request)
    {
        $user_del = User::find($user_id);
        if (empty($user_del)) {
            session()->flash("Error", "User not found");
            return response()->json([
                'status' => true,
                'message' => 'User not found'
            ]);
        }
        $user_del->delete();
        session()->flash("success", "User deleted successfully");
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}