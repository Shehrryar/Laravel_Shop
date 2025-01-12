<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ApiRoutesController extends Controller
{
    public function index()
    {
        return view("admin.webservices.create");
    }
    public function create(Request $request)
    {
        $validater = Validator::make(
            $request->all(),
            [
                'route_name' => 'required',
                'route_url' => 'required',
            ]
        );
        if ($validater->passes()) {
            return response()->json([
                'status' => true,
                'message' => 'Url added sucessfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validater->errors()
            ]);
        }
    }
}