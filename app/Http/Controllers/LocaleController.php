<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $supportedLocales = config('app.supported_locales', ['ar', 'en']);

        if (! in_array($locale, $supportedLocales, true)) {
            abort(404);
        }

        $request->session()->put('locale', $locale);

        if ($request->user()) {
            $request->user()->update(['locale' => $locale]);
        }

        return back();
    }
}
