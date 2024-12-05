<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function index($locale_id){
        App::setLocale($locale_id);
        //storing the locale in session to get it back in the middleware
        session()->put('locale', $locale_id);
        return redirect()->back();
    }


    public function dashborad(){
        return view('admin.dashboard.list');
    }
}
