<?php
namespace App\Http\Controllers;
use App\Models\Currency;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Language;
class LocalizationController extends Controller
{
    public function index($locale_id)
    {
        App::setLocale($locale_id);
        //storing the locale in session to get it back in the middleware
        session()->put('locale', $locale_id);
        return redirect()->back();
    }
    public function show()
    {
        $data = [
            'languages' => Language::where('status', 1)->get(),
        ];
        return Inertia::render('Front/Languages', $data);
    }

    public function showCurrency()
    {
        $data = [
            'currency' => Currency::where('status', 1)->get(),
        ];
        return Inertia::render('Front/Currency', $data);
    }
}