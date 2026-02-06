<?php
namespace App\Helpers;
use App\Models\Currency;
class CurrencyHelper
{
    public static function getCurrentCurrency()
    {
        $defaultCurrency = Currency::where('is_default', 1)->first();
        return $defaultCurrency;
    }
    public static function getCurrentRate(): float
    {
        return self::getCurrentCurrency()?->exchange_rate ?? 1.0;
    }
    public static function getCurrentSymbol(): string
    {
        return self::getCurrentCurrency()?->symbol ?? '$';
    }
    public static function getCurrentCode(): string
    {
        return self::getCurrentCurrency()?->code ?? 'USD';
    }
    // Optional: full object for sharing in Inertia
    public static function getCurrentCurrencyData()
    {
        $currency = self::getCurrentCurrency();
        return $currency ? [
            'id' => $currency->id,
            'code' => $currency->code,
            'name' => $currency->name,
            'symbol' => $currency->symbol,
            'rate' => $currency->exchange_rate,
        ] : null;
    }
}