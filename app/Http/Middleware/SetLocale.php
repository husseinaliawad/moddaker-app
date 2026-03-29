<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = config('app.supported_locales', ['ar', 'en']);
        $rtlLocales = config('app.rtl_locales', ['ar', 'ur']);
        $userLocale = $request->user()?->locale;
        $sessionLocale = $request->session()->get('locale');

        $locale = $sessionLocale ?: $userLocale ?: config('app.locale', 'ar');

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = config('app.locale', 'ar');
        }

        App::setLocale($locale);
        $request->session()->put('locale', $locale);

        view()->share('currentLocale', $locale);
        view()->share('direction', in_array($locale, $rtlLocales, true) ? 'rtl' : 'ltr');

        return $next($request);
    }
}
