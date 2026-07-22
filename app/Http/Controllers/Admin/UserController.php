<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', ['users' => User::with('roles')->orderBy('name')->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.users.form', ['user' => new User, 'roles' => Role::orderBy('display_name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $roles = $data['roles'] ?? [];
        unset($data['roles']);
        $user = User::create($data);
        $user->roles()->sync($roles);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', ['user' => $user, 'roles' => Role::orderBy('display_name')->get()]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validated($request, $user);
        $roles = $data['roles'] ?? [];
        unset($data['roles']);
        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }
        $user->update($data);
        $user->roles()->sync($roles);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        abort_if($request->user()->is($user), 422, 'No puede eliminar su propia cuenta.');
        abort_if($user->hasRole('super-admin'), 422, 'No puede eliminar una cuenta de superadministración.');
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:12', 'confirmed'],
            'roles' => ['array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ]);
    }
}
