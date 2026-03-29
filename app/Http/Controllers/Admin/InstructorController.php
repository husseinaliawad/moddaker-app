<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InstructorRequest;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index(Request $request): View
    {
        $query = Instructor::query()->with('user')->latest();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where('name', 'like', "%{$search}%");
        }

        $instructors = $query->paginate(12)->withQueryString();

        return view('admin.instructors.index', compact('instructors'));
    }

    public function create(): View
    {
        $users = User::query()->orderBy('name')->get();

        return view('admin.instructors.create', compact('users'));
    }

    public function store(InstructorRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $validated['avatar_path'] = $request->file('avatar')->store('instructors', 'public');
        }

        unset($validated['avatar']);

        Instructor::query()->create($validated);

        return redirect()
            ->route('admin.instructors.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function edit(Instructor $instructor): View
    {
        $users = User::query()->orderBy('name')->get();

        return view('admin.instructors.edit', compact('instructor', 'users'));
    }

    public function update(InstructorRequest $request, Instructor $instructor): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $validated['avatar_path'] = $request->file('avatar')->store('instructors', 'public');
        }

        unset($validated['avatar']);

        $instructor->update($validated);

        return redirect()
            ->route('admin.instructors.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Instructor $instructor): RedirectResponse
    {
        $instructor->delete();

        return redirect()
            ->route('admin.instructors.index')
            ->with('success', __('messages.deleted_successfully'));
    }
}
