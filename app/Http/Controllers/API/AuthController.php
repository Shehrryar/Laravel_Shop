<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
class AuthController extends Controller
{
    public function login()
    {
        $data['keyword'] = '';
        return response()->json([
            'keyword' => $data
        ]);
    }
    public function register()
    {
        $data['keyword'] = '';
        return view('front.account.register', $data);
    }
    public function processRegister(Request $request)
    {
        $request_name = ["query", "variables"];
        foreach ($request_name as $name) {
            if (!empty($request->all()[$name])) {
                $requested_data = $request->all()[$name];
                break;
            }
        }
        $validator = Validator::make($requested_data, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed',
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->name = $requested_data["name"];
            $user->email = $requested_data["email"];
            $user->phone = $requested_data["phone"];
            $user->password = Hash::make($requested_data["password"]);
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
        $request_name = ["query", "variables"];
        foreach ($request_name as $name) {
            if (!empty($request->all()[$name])) {
                $requested_data = $request->all()[$name];
                break;
            }
        }
        $validator = Validator::make($requested_data, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $requested_data["email"], 'password' => $requested_data["password"]], $request->get('remember'))) {
                $user = User::where('email', $requested_data["email"])->firstOrFail();
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => "Your are login Successfully",
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => "Crenditionals are invalid"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function profile()
    {
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'User_profile' => $user
        ]);
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
        } else if ($userExists && $userExists->role == 1) {
            if ($userExists->google_id == $gitUser->id) {
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
    public function googleRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $userExists = User::where('email', $googleUser->email)
            ->first();
        if ($userExists && $userExists->role == 2) {
            session()->flash('error', 'The email already exists for admin');
            return redirect()->route('admin.login');
        } else if ($userExists && $userExists->role == 1) {
            if ($userExists->google_id == $googleUser->id) {
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
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }
    public function facebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        $userExists = User::where('email', $facebookUser->email)
            ->first();
        if ($userExists && $userExists->role == 2) {
            session()->flash('error', 'The email already exists for admin');
            return redirect()->route('admin.login');
        } else if ($userExists && $userExists->role == 1) {
            if ($userExists->facebook_id == $facebookUser->id) {
                Auth::login($userExists);
                session()->flash('success', 'Welcome to the Dashboard');
                return redirect()->route('front.home');
            }
            session()->flash('error', 'Account already exist enter your Email and Password');
            return redirect()->route('account.login');
        }
        $user = new User();
        $user->facebook_id = $facebookUser->id;
        $user->name = $facebookUser->name;
        $user->email = $facebookUser->email;
        $user->password = Hash::make('12345678');
        $user->token = $facebookUser->token;
        $user->save();
        Auth::login($user);
        session()->flash('success', 'Your account is created successfully');
        return redirect()->route('front.home');
    }
    public function wishlist()
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
        $data = [];
        $data['wishlist'] = $wishlist;
        return response()->json([
            'data' => $data,
        ]);
    }
    public function remove_product_from_wishlist(Request $request)
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)
            ->where('product_id', $request->id)
            ->first();
        if ($wishlist == null) {
            session()->flash('error', 'Product already removed');
            return response()->json([
                'status' => true,
            ]);
        } else {
            $wishlist->delete();
            session()->flash('success', 'Product removed successfully');
            return response()->json([
                'status' => true,
            ]);
        }
    }
    public function order()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderby('created_at', 'DESC')->get();
        $data['orders'] = $orders;
        return response()->json([
            'data' => $data,
        ]);
    }
    public function orderdetail($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('id', $id)->first();
        $orderitems = OrderItem::where('order_id', $id)->get();
        $orderitemscount = OrderItem::where('order_id', $id)->count();
        $data['order'] = $order;
        $data['orderitemscount'] = $orderitemscount;
        $data['orderitems'] = $orderitems;
        return response()->json([
            'data' => $data,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        // ->tokens()->delete();
        return response()->json([
            'message' => 'Your successfully logout'
        ]);
    }
}