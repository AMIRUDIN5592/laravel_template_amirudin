<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Support\Permissions;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display the role & permission matrix.
     */
    public function index(): View
    {
        $roles = Role::orderBy('name')->get();
        $permissions = Permissions::all();

        return view('roles.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $permissions = Permissions::all();

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|alpha_dash|max:50|unique:roles,name',
            'label' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:'.implode(',', Permissions::all()),
        ]);

        $data['name'] = strtolower($data['name']);
        $data['permissions'] = array_values(array_intersect(
            Permissions::all(),
            $data['permissions'] ?? []
        ));

        Role::create($data);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }

    /**
     * Persist the permission grants for each role.
     */
    public function update(Request $request): RedirectResponse
    {
        $valid = $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'array',
            'roles.*.*' => 'string|in:'.implode(',', Permissions::all()),
        ]);

        $submitted = $valid['roles'] ?? [];

        foreach (Role::all() as $role) {
            if ($role->name === User::ROLE_SUPER_ADMIN) {
                // Superadmin is always granted every permission.
                $role->update(['permissions' => ['*']]);

                continue;
            }

            $granted = array_values(array_intersect(
                Permissions::all(),
                $submitted[$role->name] ?? []
            ));

            $role->update(['permissions' => $granted]);
        }

        return redirect()
            ->route('roles.index')
            ->with('success', 'Hak akses role berhasil diperbarui.');
    }
}
