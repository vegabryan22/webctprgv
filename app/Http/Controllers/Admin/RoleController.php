<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('admin.roles.index', ['roles' => Role::withCount('users')->orderBy('display_name')->get()]);
    }

    public function create(): View
    {
        return view('admin.roles.form', ['role' => new Role, 'permissions' => Permission::orderBy('group')->orderBy('display_name')->get()->groupBy('group')]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['name' => Str::slug((string) $request->input('name'))]);
        $data = $this->validated($request);
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);
        $data['name'] = Str::slug($data['name']);
        $role = Role::create($data);
        $role->permissions()->sync($permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function edit(Role $role): View
    {
        return view('admin.roles.form', ['role' => $role, 'permissions' => Permission::orderBy('group')->orderBy('display_name')->get()->groupBy('group')]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        abort_if($role->is_system, 422, 'Los roles del sistema no se pueden modificar.');
        $request->merge(['name' => Str::slug((string) $request->input('name'))]);
        $data = $this->validated($request, $role);
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);
        $data['name'] = Str::slug($data['name']);
        $role->update($data);
        $role->permissions()->sync($permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        abort_if($role->is_system, 422, 'Los roles del sistema no se pueden eliminar.');
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado correctamente.');
    }

    private function validated(Request $request, ?Role $role = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('roles')->ignore($role)],
            'display_name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'permissions' => ['array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);
    }
}
