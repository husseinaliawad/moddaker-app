<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $locale = app()->getLocale();
            $rtlLocales = config('app.rtl_locales', ['ar', 'ur']);

            $view->with('supportedLocales', config('app.supported_locales', ['ar', 'en']));
            $view->with('localeLabels', config('app.locale_labels', []));
            $view->with('textDirection', in_array($locale, $rtlLocales, true) ? 'rtl' : 'ltr');
            $view->with('siteContact', Setting::getValue('site.contact', [
                'email' => 'info@moddaker.com',
                'phone' => '+966500000000',
            ]));
            $view->with('siteSocialLinks', Setting::getValue('site.social_links', [
                ['platform' => 'X', 'url' => '#'],
                ['platform' => 'YouTube', 'url' => '#'],
                ['platform' => 'Telegram', 'url' => '#'],
            ]));
        });

        View::composer('layouts.admin', function ($view): void {
            try {
                $unreadMessages = ContactMessage::query()->where('is_read', false)->count();
            } catch (Throwable) {
                $unreadMessages = 0;
            }

            $view->with('adminUnreadMessages', $unreadMessages);
        });
    }
}
