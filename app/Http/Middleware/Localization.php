<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;


class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

            if (session()->has('locale')) {
                $locale = session()->get('locale');
                App::setLocale($locale);
            }
    
            if ($request->is('admin/*')) {
                $path = resource_path('lang/admin/' . App::getLocale() . '.json');
            } else {
                $path = resource_path('lang/front/' . App::getLocale() . '.json');

            }
    
            if (File::exists($path)) {
                $translations = json_decode(File::get($path), true);
                Lang::setLoaded([App::getLocale() => $translations]);
            }
    
            return $next($request);
        }
}
