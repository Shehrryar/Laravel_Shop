<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
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
        $language = Language::where('Isocode', $locale_id)
            ->where('status', 1)
            ->firstOrFail();
        Language::where('is_default', 1)->update(['is_default' => 0]);
        $language->is_default = 1;
        $language->save();
        App::setLocale($locale_id);
        session()->put('locale', $locale_id);
        return redirect()->back();
    }
    public function show()
    {
        return Inertia::render('Front/Languages', [
            'languages' => Language::where('status', 1)->get(),
            'default_language' => Language::where('is_default', 1)->first(),
        ]);
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