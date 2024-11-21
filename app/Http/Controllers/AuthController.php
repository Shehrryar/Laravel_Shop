<?php
namespace App\Http\Controllers;
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
        return view('front.account.login', $data);
    }
    public function register()
    {
        $data['keyword'] = '';
        return view('front.account.register',$data);
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
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
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
        $data['keyword'] = '';
        return view('front.account.profile', $data);
    }
    public function profileEdit()
    {
        $data['keyword'] = '';
        return view('front.account.updateprofile', $data);
    }
    
    public function updateProfileData(Request $request)
    {
        echo "<pre>";
        print_r($request->all());
        exit;
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
                if($userExists->status == 1){
                    Auth::login($userExists);
                    session()->flash('success', 'Welcome to the Dashboard');
                    return redirect()->route('front.home');
                }else{
                    session()->flash('error', 'Your account  is disabled. Please contact to the admin');
                    return redirect()->route('account.login'); 
                }

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

    public function facebookRedirect(){
        return Socialite::driver('facebook')->stateless()->redirect();
    }
    public function facebookCallback(){
        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        $userExists = User::where('email', $facebookUser->email)
        ->first();
        if ($userExists && $userExists->role == 2) {
            session()->flash('error', 'The email already exists for admin');
            return redirect()->route('admin.login');
        }
        else if($userExists && $userExists->role == 1){
            if($userExists->facebook_id == $facebookUser->id){
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
    public function wishlist(){
       $wishlist = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
       $data = [];
       $data['wishlist'] = $wishlist;
       $data['keyword'] = '';

       return view('front.account.wishlist', $data);
    }
    public function remove_product_from_wishlist(Request $request) {
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
    public function order(){
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderby('created_at','DESC')->get();
        $data['orders'] = $orders;
        $data['keyword'] = ''; 
        return view('front.account.order', $data);
    }
    public function orderdetail($id){
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('id',$id)->first();
        $orderitems = OrderItem::where('order_id', $id)->get();
        $orderitemscount = OrderItem::where('order_id', $id)->count();
        $data['order'] = $order; 
        $data['orderitemscount'] = $orderitemscount; 
        $data['orderitems'] = $orderitems; 
        $data['keyword'] = ''; 
        return view('front.account.orderdetail', $data);
    }
}