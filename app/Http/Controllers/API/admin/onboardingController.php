<?php
namespace App\Http\Controllers\API\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Onboarding;
use Illuminate\Support\Facades\File;
class onboardingController extends Controller
{
    public function index(Request $request)
    {
        $onboarding = Onboarding::latest();
        if (!empty($request->get('keyword'))) {
            $onboarding = $onboarding->where('title', 'like', '%' . $request->get('keyword') . '%');
        }
        $onboarding = $onboarding->paginate(10);
        $totalPages = $onboarding->lastPage(); // Total number of pages
        $currentPage = $onboarding->currentPage(); // Current page number
        $onboardingData = $onboarding->items(); // Extract onboarding as an array
        $newonboarding['current_page'] = $currentPage;
        $newonboarding['totalPages'] = $totalPages;
        $newonboarding['onboardingData'] = $onboardingData;
        return response()->json([$newonboarding]);
    }
    public function store(Request $request)
    {
        $validater = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'subtitle' => 'required',
            ]
        );
        if ($validater->passes()) {
            $Onboarding = new Onboarding();
            $Onboarding->title = $request->title;
            $Onboarding->subtitle = $request->subtitle;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $destinationPath = public_path('upload/onboarding/');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
                $image->move($destinationPath, $imageName);
                $Onboarding->image = $imageName;
            }
            $Onboarding->save();
            return response()->json([
                'status' => true,
                'message' => 'Onboarding is added'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validater->errors()
            ]);
        }
    }
    public function update($onbord_id, Request $request)
    {
        $onbord_edit = Onboarding::find($onbord_id);
        if (empty($onbord_edit))
            return response()->json([
                'status' => false,
                'not found' => true,
                'message' => 'onboarding not found'
            ]);
        $validater = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'subtitle' => 'required',
            ]
        );
        if ($validater->passes()) {
            $onbord_edit->title = $request->title;
            $onbord_edit->subtitle = $request->subtitle;
            // $onbord_edit->save();
            $oldimage = $onbord_edit->image;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $destinationPath = public_path('upload/onboarding/');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }
                $image->move($destinationPath, $imageName);
                $onbord_edit->image = $imageName;
                if (!empty($oldimage)) {
                    File::delete(public_path() . '/upload/onboarding/' . $oldimage);
                }
            }
            $onbord_edit->save();
            return response()->json([
                'status' => true,
                'message' => 'onboarding updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validater->errors()
            ]);
        }
    }
    public function destroy($onbord_id, Request $request)
    {
        $onbord_del = Onboarding::find($onbord_id);
        if (empty($onbord_del)) {
            return response()->json([
                'status' => true,
                'message' => 'onboarding not found'
            ]);
        }
        File::delete(public_path() . '/upload/onboarding/' . $onbord_del->image);
        $onbord_del->delete();
        return response()->json([
            'status' => true,
            'message' => 'onboarding deleted successfully'
        ]);
    }
}