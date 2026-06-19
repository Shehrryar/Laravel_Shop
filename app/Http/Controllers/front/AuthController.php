<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\DiscountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Wishlist;
use App\Models\Country;
use App\Models\Product;
use App\Models\CustomerAddress;
use PDF;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
class AuthController extends Controller
{
    protected $discountService;
    public function __construct(
        DiscountService $discountService,
    ) {
        $this->discountService = $discountService;
    }
    public function login()
    {
        // $data['keyword'] = '';
        return Inertia::render('Front/Account/Login');
        // return view('front.account.login', $data);
    }
    public function address()
    {
        $data['keyword'] = '';
        $customer_address = CustomerAddress::where('user_id', Auth::id())->first();
        $countries = Country::all();
        $data['customer_address'] = $customer_address;
        $data['countries'] = $countries;
        return view('front.account.address', $data);
    }
    public function addressupdate(Request $request)
    {
        $customer_address = CustomerAddress::where('user_id', Auth::id())->first();
        if ($customer_address) {
            $customer_address->address = $request->address;
            $customer_address->city = $request->city;
            $customer_address->state = $request->state;
            $customer_address->country_id = $request->country_id;
            $customer_address->zip = $request->zip;
            $customer_address->save();
        }
        $message = 'Address updated successfully!';
        // session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
    public function register()
    {
        // $data['keyword'] = '';
        // return view('front.account.register', $data);
        return Inertia::render('Front/Account/Register');
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
            // $user->fcm_token = $request->fcm_token;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();
            $message = 'You have been registered Successfully';
            return redirect()
                ->route('account.login')
                ->with('success', $message);
            // return response()->json([
            //     'status' => true,
            //     'message' => $message
            // ]);
        } else {
            return back()->withErrors($validator)->withInput();
            // return response()->json([
            //     'status' => false,
            //     'errors' => $validator->errors()
            // ]);
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
                $message = 'Your Successfully logged in';
                return redirect()
                    ->route('front.home')
                    ->with('success', $message);
                // return redirect()->route('account.profile');
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
        $user = Auth::user();
        return Inertia::render('Front/Account/Profile', [
            'user' => $user,
        ]);
    }
    public function profileEdit()
    {
        $user = Auth::user();
        return Inertia::render('Front/Account/ProfileSetting', [
            'user' => $user,
        ]);
    }
    public function updateProfileData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'mobile_number' => 'required|string|max:20',
            'password' => 'nullable|min:6',
        ]);
        if ($validator->passes()) {
            $user = auth()->user();
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'date_of_birth' => $request->dob,
                'gender' => $request->gender,
                'phone' => $request->mobile_number,
                'password' => $request->filled('password')
                    ? bcrypt($request->password)
                    : $user->password,
            ]);
            return redirect()->route('account.profile')->with('success', 'Profile updated successfully!');
        } else {
            return back()->withErrors($validator)->withInput();
        }
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
                if ($userExists->status == 1) {
                    Auth::login($userExists);
                    session()->flash('success', 'Welcome to the Dashboard');
                    return redirect()->route('front.home');
                } else {
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
        $wishlistProductIds = Wishlist::where('user_id', Auth::id())
            ->pluck('product_id')
            ->toArray();
        $products = Product::where('status', 1)
            ->whereIn('id', $wishlistProductIds)
            ->with('product_images')
            ->withCount('product_ratings')
            ->withSum('product_ratings', 'rating')
            ->get();
        $wishlist = Wishlist::where('user_id', Auth::id())->get();
        $products = $products->map(function ($product) use ($wishlist) {
            $wish = $wishlist->where('product_id', $product->id)->first();
            $product->color_id = $wish->color_id ?? null;
            $product->size_id = $wish->size_id ?? null;
            return $product;
        });
        $discounts = $this->discountService->getActiveDiscounts();
        $wishlistProducts = $this->discountService->applyDiscount(
            $products,
            $discounts
        );
        $data = [
            'wishlist' => $wishlistProducts,
            'keyword' => '',
        ];
        return Inertia::render('Front/Account/Wishlist', $data);
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
        // $orders = Order::where('user_id', $user->id)->orderby('created_at', 'DESC')->get();
        $orders = Order::with('orderitems.product.product_images')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();
        $data['orders'] = $orders;
        $data['keyword'] = '';
        return Inertia::render('Front/Account/OrderHistory', $data);
        // return view('front.account.order', $data);
    }
    public function orderDetails($orderId)
    {
        $order = Order::with('orderItems.product.product_images') // eager load items + product details
            ->where('user_id', auth()->id())
            ->where('id', $orderId)
            ->first();
        $data['order'] = $order;
        return Inertia::render('Front/OrderDetails', $data);
    }
    public function newAddress()
    {
        $user = Auth::user();
        $countries = Country::orderBy('name', 'ASC')->get();
        $emptyAddress = [
            'id' => null,
            'firstname' => $user->name ?? '',
            'lastname' => '',
            'email' => $user->email ?? '',
            'mobile' => $user->phone ?? '',
            'country_id' => '',
            'flat' => '',
            'area' => '',
            'landmark' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'pin_code' => '',
            'address_type' => '',
            'is_default' => 0,
            'apartment' => '',
            'address' => '',
        ];
        $data['user'] = $user;
        $data['editdata'] = 'newForm';
        $data['editaddress'] = $emptyAddress;
        $data['countries'] = $countries;
        return Inertia::render('Front/Account/Address', $data);
    }
    public function EditAddress($id)
    {
        $address = CustomerAddress::where('id', $id)->first();
        $user = Auth::user();
        $countries = Country::orderBy('name', 'ASC')->get();
        $data['editdata'] = 'updateForm';
        $data['editaddress'] = $address;
        $data['user'] = $user;
        $data['countries'] = $countries;
        return Inertia::render('Front/Account/Address', $data);
    }
    public function savedAddress()
    {
        $customeraddresses = collect(); // empty collection by default
        if (Auth::check()) {
            $customeraddresses = CustomerAddress::where('user_id', Auth::id())->get();
        }
        $data = [
            'customeraddresses' => $customeraddresses,
        ];
        return Inertia::render('Front/Account/SavedAddress', $data);
    }
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'country_id' => 'required|exists:countries,id',
            'pin_code' => 'required|string|max:20',
            'flat' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address_type' => 'required|string|max:50',
            'is_default' => 'nullable|boolean',
            'landmark' => 'nullable|string|max:255',
        ]);
        $userId = $validated['user_id'];
        $isDefault = $request->is_default ?? 0;
        // If default address selected → reset all other addresses
        if ($isDefault == 1) {
            CustomerAddress::where('user_id', $userId)
                ->update(['is_default' => 0]);
        }
        // -----------------------------------
        // CREATE NEW ADDRESS
        // -----------------------------------
        if ($request->editform == "newForm") {
            $address = CustomerAddress::create([
                'user_id' => $userId,
                'firstname' => auth()->user()->name ?? '',
                'lastname' => '',
                'email' => auth()->user()->email ?? '',
                'mobile' => auth()->user()->phone ?? '',
                'country_id' => $validated['country_id'],
                'flat' => $validated['flat'],
                'area' => $validated['area'],
                'landmark' => $request->landmark ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip' => $validated['pin_code'],
                'pin_code' => $validated['pin_code'],
                'address_type' => $validated['address_type'],
                'is_default' => $isDefault,
                'apartment' => $request->flat ?? null,
                'address' => $validated['area'],
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Address added successfully!',
                'data' => $address,
            ]);
        }
        // -----------------------------------
        // UPDATE EXISTING ADDRESS
        // -----------------------------------
        $address = CustomerAddress::find($request->id);
        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found!',
            ]);
        }
        $address->update([
            'country_id' => $validated['country_id'],
            'flat' => $validated['flat'],
            'area' => $validated['area'],
            'landmark' => $request->landmark ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip' => $validated['pin_code'],
            'pin_code' => $validated['pin_code'],
            'address_type' => $validated['address_type'],
            'is_default' => $isDefault,
            'apartment' => $request->flat ?? null,
            'address' => $validated['area'],
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Address updated successfully!',
            'data' => $address,
        ]);
    }
    public function removeAddress(Request $request)
    {
        $address = CustomerAddress::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->first();
        if (!$address) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found or unauthorized.',
            ]);
        }
        $address->delete();
        return response()->json([
            'status' => true,
            'message' => 'Address removed successfully.',
        ]);
    }
    public function invoiceHtml($orderId)
    {
        $order = Order::with('orderItems.product')
            ->where('user_id', auth()->id())
            ->findOrFail($orderId);
        // Return JSON to frontend for generating downloadable HTML
        return response()->json($order);
    }
    public function searchOrders(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        $query = Order::with(['orderitems.product.product_images'])
            ->where('user_id', $user->id);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }
        $orders = $query->latest()->get();
        return Inertia::render('Account/OrderHistory', [
            'orders' => $orders, // ✅ ONLY orders
        ]);
    }
}