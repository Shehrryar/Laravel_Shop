<?php
namespace App\Http\Controllers\API\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class AdminLoginController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Admin Login',
        ]);
    }
    public function authenticate(Request $request)
    {
        $validater = Validator::make(
            $request->all(),
            [
                'email' => 'required | email',
                'password' => 'required'
            ]
        );
        if ($validater->passes()) {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                $admin = Auth::guard('admin')->user();
                if ($admin->role == 2) {
                    $token = $admin->createToken('auth_token')->plainTextToken;
                    $admin->personal_access_token_id = $token;
                    $admin->save();
                    return response()->json([
                        'status' => true,
                        'message' => " loggedin Successfully",
                        'access_token' => $token,
                        'token_type' => 'Bearer'
                    ]);
                    // return redirect()->route('admin.dashboard');
                } else {
                    $admin = Auth::guard('admin')->logout();
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid Admin Email/Password',
                    ]);
                    // return redirect()->route('admin.login')->with('error', 'you are not authorized to access admin panal');
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Either Email/Password is incorrect',
                ]);
                // return redirect()->route('admin.login')->with('error', 'Either Email/Password is incorrect');
            }
        } else {
            // return redirect()->route('admin.login')->withErrors($validater)->withInput($request->only('email'));
            return response()->json([
                'status' => false,
                'message' => 'Invalid Credinatials',
            ]);
        }
    }
    public function logout(Request $request)
    {
        $admin = Auth::user();
        if ($admin) {
            $admin->tokens()->where('id', $admin->personal_access_token_id)->delete();
            $admin->personal_access_token_id = null;
            $admin->save();
            return response()->json([
                'message' => 'You have successfully logged out'
            ]);
        } else {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }
}