<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactMessageRequest;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function create(): View
    {
        $contactInfo = Setting::getValue('site.contact', [
            'email' => 'info@moddaker.com',
            'phone' => '+966500000000',
            'address' => [
                'ar' => 'الرياض، المملكة العربية السعودية',
                'en' => 'Riyadh, Saudi Arabia',
            ],
        ]);

        return view('frontend.contact', compact('contactInfo'));
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::query()->create($request->validated());

        return back()->with('success', __('messages.contact_sent'));
    }
}
