<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;




class AuthController extends Controller
{
    public function login()
    {
        return view('front.account.login');
    }

    public function register()
    {
        return view('front.account.register');
    }


    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();
            $message = 'You have been registered Successfully';
            session()->flash('success', $message);

            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'google_id' => $request->password], $request->get('remember'))) {
                if (session()->has('url.intended')) {
                    return redirect(session()->get('url.intended'));
                }
                return redirect()->route('account.profile');
            } else {
                // session()->flash('error', 'Either email/password is incorrect');
                return redirect()->route('account.login')
                    ->withInput($request->only('email'))->with('error', 'Either email/password is incorrect');
            }
        } else {
            return redirect()
                ->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }
    public function profile()
    {
        return view('front.account.profile');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login')->with('success', 'Your successfully logout');
    }


    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();
    }
    public function githubCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        // Check if the email exists
        $emailExists = User::where('email', $githubUser->email)->exists();

        if ($emailExists) {
            $message = 'The email is Already Exist';
            session()->flash('success', $message);
            return redirect()->route('account.login')->with('success', $message);
        } else {
            $user = new User();
            $user->github_id = $githubUser->id;
            $user->name = $githubUser->name;
            $user->email = $githubUser->email;
            $user->password = Hash::make('12345678');
            $user->token = $githubUser->token;
            $user->save();
            $message = 'You have been registered Successfully';
            session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);
        }
    }


    public function googleRedirect(){
        return Socialite::driver('google')->redirect();
        
    }

    public function googleCallback(){
        $googleUser = Socialite::driver('google')->user();
        $emailExists = User::where('email', $googleUser->email)->exists();




        if ($emailExists) {
            $message = 'The email is Already Exist';
            session()->flash('error', $message);
            return redirect()->route('account.login');
        } else {
            $user = new User();
            $user->google_id  = $googleUser->id;
            $user->name = $googleUser->name;
            $user->email = $googleUser->email;
            $user->password = Hash::make('12345678');
            $user->token = $googleUser->token;
            $user->save();
            $message = 'You have been registered Successfully';
            session()->flash('success', $message);
            return redirect()->route('account.login');
        }

        
    }
}
