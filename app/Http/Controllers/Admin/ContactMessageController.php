<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::query()->latest();

        if ($request->filled('status')) {
            $isRead = $request->string('status')->toString() === 'read';
            $query->where('is_read', $isRead);
        }

        $messages = $query->paginate(15)->withQueryString();

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage): View
    {
        if (! $contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function update(Request $request, ContactMessage $contactMessage): RedirectResponse
    {
        $validated = $request->validate([
            'is_read' => ['required', 'boolean'],
        ]);

        $contactMessage->update([
            'is_read' => (bool) $validated['is_read'],
            'replied_at' => (bool) $validated['is_read'] ? now() : null,
        ]);

        return back()->with('success', __('messages.updated_successfully'));
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return back()->with('success', __('messages.deleted_successfully'));
    }
}
