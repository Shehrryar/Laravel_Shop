<?php
namespace App\Http\Controllers;
use App\Models\Currency;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Language;
use Illuminate\Validation\Rule;
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
        $currencies = Currency::where('status', 1)->get();
        $defaultCurrency = Currency::where('is_default', 1)->first() ?? $currencies->first();
        $currentCurrency = Currency::where('code', $defaultCurrency?->code)
            ->where('status', 1)
            ->first() ?? $defaultCurrency;
        $data = [
            'currency' => $currencies,
            'current_currency' => $currentCurrency,
        ];
        return Inertia::render('Front/Currency', $data);
    }
    public function change(Request $request)
    {
        $request->validate([
            'currency' => ['required', Rule::exists('currencies', 'code')->where('status', 1)],
        ]);
        // Reset all currencies default to 0
        Currency::where('is_default', 1)->update(['is_default' => 0]);
        //Set selected currency as default
        Currency::where('code', $request->currency)
            ->where('status', 1)
            ->update(['is_default' => 1]);
        //Store selected currency in session (frontend use)
        session()->put('currency_code', $request->currency);
        return redirect()->route('front.currency');
    }
}