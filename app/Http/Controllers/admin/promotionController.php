<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
class promotionController extends Controller
{
    public function index(Request $request)
    {
        $promotions = Promotion::paginate(10);
        return view('admin.promotions.list', compact('promotions'));
    }
    public function create()
    {
        return view('admin.promotions.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
        ]);
        if ($validator->passes()) {
            Promotion::create($request->all());
            $firebase = (new Factory)->withServiceAccount(base_path('config/firebase_credentials.json'));
            $messaging = $firebase->createMessaging();
            $message = CloudMessage::fromArray([
                'notification' => [
                    'title' => 'Hello from Firebase!',
                    'body' => $request->description
                ],
                'topic' => 'global'
            ]);
            $response = $messaging->send($message);
            return response()->json([
                'status' => true,
                'message' => 'Push notification sent successfully',
                'response' => $response,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id)
    {
        $promotion = Promotion::find($id);
        if ($promotion) {
            return view('admin.promotions.edit', compact('promotion'));
        } else {
            return redirect()->route('admin.promotions.index')->with('error', 'Promotion not found');
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
        ]);
        if ($validator->passes()) {
            $promotion = Promotion::find($id);
            if (!$promotion) {
                return response()->json([
                    'status' => false,
                    'errors' => ['Promotion not found']
                ]);
            }
            $promotion->description = $request->description;
            $promotion->save();
            $firebase = (new Factory)->withServiceAccount(base_path('config/firebase_credentials.json'));
            $messaging = $firebase->createMessaging();
            $message = CloudMessage::fromArray([
                'notification' => [
                    'title' => 'Hello from Firebase!',
                    'body' => $request->description
                ],
                'topic' => 'global'
            ]);
            $response = $messaging->send($message);
            return response()->json([
                'status' => true,
                'message' => 'Push notification sent successfully',
                'response' => $response,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($id)
    {
        $promotion = Promotion::find($id);
        if ($promotion) {
            $promotion->delete();
            return response()->json([
                'status' => true,
                'success' => "Promotion Deleted Successfully",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => ['Promotion not found']
            ]);
        }
    }

}