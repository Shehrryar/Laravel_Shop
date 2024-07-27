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
        $gitUser = Socialite::driver('github')->stateless()->user();
        $userExists = User::where('email', $gitUser->email)
        ->first();
        if ($userExists && $userExists->role == 2) {
            session()->flash('error', 'The email already exists for admin');
            return redirect()->route('admin.login');
        }
        else if($userExists && $userExists->role == 1){
            if($userExists->google_id == $gitUser->id){
                Auth::login($userExists);
                session()->flash('success', 'Welcome to the Dashboard');
                return redirect()->route('front.home');
            }
            session()->flash('error', 'Account already exist enter your Email and Password');
            return redirect()->route('account.login');
        }
        $user = new User();
        $user->github_id = $gitUser->id;
        $user->name = $gitUser->name;
        $user->email = $gitUser->email;
        $user->password = Hash::make('12345678');
        $user->token = $gitUser->token;
        $user->save();
        Auth::login($user);
        session()->flash('success', 'Your account is created successfully');
        return redirect()->route('front.home');
    }

    public function googleRedirect(){
        return Socialite::driver('google')->stateless()->redirect();
    }
    public function googleCallback(){
        $googleUser = Socialite::driver('google')->stateless()->user();
        $userExists = User::where('email', $googleUser->email)
        ->first();
        if ($userExists && $userExists->role == 2) {
            session()->flash('error', 'The email already exists for admin');
            return redirect()->route('admin.login');
        }
        else if($userExists && $userExists->role == 1){
            if($userExists->google_id == $googleUser->id){
                Auth::login($userExists);
                session()->flash('success', 'Welcome to the Dashboard');
                return redirect()->route('front.home');
            }
            session()->flash('error', 'Account already exist enter your Email and Password');
            return redirect()->route('account.login');
        }
        $user = new User();
        $user->google_id = $googleUser->id;
        $user->name = $googleUser->name;
        $user->email = $googleUser->email;
        $user->password = Hash::make('12345678');
        $user->token = $googleUser->token;
        $user->save();
        Auth::login($user);
        session()->flash('success', 'Your account is created successfully');
        return redirect()->route('front.home');
    }
    
}