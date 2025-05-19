<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Webservice;
class ApiRoutesController extends Controller
{
    public function index()
    {
        $Webservice = Webservice::paginate(10);
        return view("admin.webservices.admin.create", compact('Webservice'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'api_type' => 'required',
                'api_url' => 'required',
                'api_name' => 'required',
                'api_description' => 'nullable',
                'api_payload' => 'nullable',
                'api_response' => 'nullable',
            ]
        );

        if ($validator->passes()) {
            $Webservice = new Webservice();
            $Webservice->api_type = $request->api_type;
            $Webservice->api_url = $request->api_url;
            $Webservice->api_name = $request->api_name;
            $Webservice->api_description = $request->api_description;
            $Webservice->api_payload = $request->api_payload;
            $Webservice->api_response = $request->api_response;
            $Webservice->api_side = 0;
            $Webservice->save();

            $request->session()->flash('success', 'API URL added successfully');
            return response()->json([
                'status' => true,
                'message' => 'URL added successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}