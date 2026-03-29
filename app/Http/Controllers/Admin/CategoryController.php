<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Category::query()->with('translations')->orderBy('sort_order');

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('slug', 'like', "%{$search}%")
                    ->orWhereHas('translations', fn ($translationQuery) => $translationQuery->where('name', 'like', "%{$search}%"));
            });
        }

        $categories = $query->paginate(12)->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $category = Category::query()->create([
            'slug' => $validated['slug'],
            'icon' => $validated['icon'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        $this->syncTranslations($category, $validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function edit(Category $category): View
    {
        $category->load('translations');

        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();

        $category->update([
            'slug' => $validated['slug'],
            'icon' => $validated['icon'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        $this->syncTranslations($category, $validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', __('messages.deleted_successfully'));
    }

    private function syncTranslations(Category $category, array $validated): void
    {
        foreach (['ar', 'en'] as $locale) {
            $category->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'name' => $validated['name_'.$locale],
                    'description' => $validated['description_'.$locale] ?? null,
                ]
            );
        }
    }
}
