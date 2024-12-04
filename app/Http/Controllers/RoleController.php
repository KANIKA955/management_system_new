<?php

namespace App\Http\Controllers;
use App\Helpers\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return Inertia::render('Role/Index', [
            'roles' => $roles,
            'permissionGroups' => $this->getPermissionGroups()
        ]);
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        return Inertia::render('Role/Form', [
            'role' => $role,
            'permissionGroups' => $this->getPermissionGroups()
        ]);
    }


    public function create()
    {
        return Inertia::render('Role/Form', [
            'permissionGroups' => $this->getPermissionGroups()
        ]);
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);
        $role = Role::create(['name' => $validated['name'],'guard_name' => 'web']);
        $permissions = Permission::find($validated['permissions'])->pluck('name')->toArray();
        $role->syncPermissions($permissions);
        Toast::success($role->name . '- Role created successfully.');
        return to_route('roles.index');

    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array|nullable',
        ]);
        try {
            $role->update(['name' => $validated['name']]);
            $permissions = Permission::find($validated['permissions'])->pluck('name')->toArray();
            $role->syncPermissions($permissions);
            Toast::success($role->name . '- Role updated successfully.');
        } catch (\Exception $e) {
            Toast::error('An error occurred while updating the role.');
        }
        return to_route('roles.index');
    }


    private function getPermissionGroups()
    {
        return Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[0];
        })->map(function ($group, $groupName) {
            return [
                'name' => $groupName,
                'permissions' => $group->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => explode(' ', $permission->name)[1]
                    ];
                })->values()
            ];
        })->values();
    }
}
