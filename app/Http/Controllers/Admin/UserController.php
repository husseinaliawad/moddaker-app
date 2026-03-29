<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->with('roles')->latest();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(12)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::query()->orderBy('name')->get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $roles = $validated['roles'] ?? ['student'];
        unset($validated['roles'], $validated['avatar']);

        $user = User::query()->create($validated);
        $user->syncRoles($roles);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function edit(User $user): View
    {
        $roles = Role::query()->orderBy('name')->get();
        $user->load('roles');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $roles = $validated['roles'] ?? ['student'];
        unset($validated['roles'], $validated['avatar']);

        $user->update($validated);
        $user->syncRoles($roles);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', __('messages.cannot_delete_self'));
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.deleted_successfully'));
    }
}
