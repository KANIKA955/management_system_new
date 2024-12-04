<?php

namespace App\Http\Controllers;

use App\Helpers\Toast;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return Inertia::render('Permission/Index', [
            'permissions' => Permission::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Permission/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        Permission::create(['name' => $validated['name']]);
        Toast::success('Permission created successfully.');
        return to_route('permissions.index');
    }

    public function show($id)
    {
        // Logic to show a specific permission (if needed)
        return response()->json(Permission::findOrFail($id));
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return Inertia::render('Permission/Form', [
            'permission' => $permission // Pass permission to edit
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name,' . $id
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $validated['name']]);

        return response()->json(['message' => 'Permission updated successfully.']);
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully.']);
    }
}
