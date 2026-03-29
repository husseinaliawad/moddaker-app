<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Page::query()->with('translations')->latest();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('slug', 'like', "%{$search}%")
                    ->orWhereHas('translations', fn ($translationQuery) => $translationQuery->where('title', 'like', "%{$search}%"));
            });
        }

        $pages = $query->paginate(12)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(PageRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $page = Page::query()->create([
            'slug' => $validated['slug'],
            'template' => $validated['template'] ?? 'default',
            'is_published' => (bool) ($validated['is_published'] ?? false),
        ]);

        $this->syncTranslations($page, $validated);

        return redirect()->route('admin.pages.index')->with('success', __('messages.created_successfully'));
    }

    public function edit(Page $page): View
    {
        $page->load('translations');

        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        $validated = $request->validated();

        $page->update([
            'slug' => $validated['slug'],
            'template' => $validated['template'] ?? 'default',
            'is_published' => (bool) ($validated['is_published'] ?? false),
        ]);

        $this->syncTranslations($page, $validated);

        return redirect()->route('admin.pages.index')->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', __('messages.deleted_successfully'));
    }

    private function syncTranslations(Page $page, array $validated): void
    {
        foreach (['ar', 'en'] as $locale) {
            $page->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $validated['title_'.$locale],
                    'excerpt' => $validated['excerpt_'.$locale] ?? null,
                    'content' => $validated['content_'.$locale] ?? null,
                ]
            );
        }
    }
}
