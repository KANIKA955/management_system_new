<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionGroups = [
            'User' => ['view', 'create', 'edit', 'delete'],
            'Role' => ['view', 'create', 'edit', 'delete'],
            'Permission' => ['view', 'create', 'edit', 'delete'],
            'Team' => ['view', 'create', 'edit', 'delete'],
            'Category' => ['view', 'create', 'edit', 'delete'],
            'Chat' => ['view', 'handle', 'transfer'],
            'Disputes' => ['view', 'handle', 'resolve'],
        ];

        foreach ($permissionGroups as $group => $permissions) {
            foreach ($permissions as $permission) {
                Permission::create(['name' => $group . ' ' . $permission]);
            }
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'User view', 'User edit',
            'Team view', 'Team create', 'Team edit', 'Team delete',
            'Category view', 'Category create', 'Category edit', 'Category delete',
            'Chat view', 'Chat handle', 'Chat transfer',
            'Disputes view', 'Disputes handle', 'Disputes resolve',
        ]);

        $teamLeadRole = Role::create(['name' => 'team_lead']);
        $teamLeadRole->givePermissionTo([
            'User view',
            'Team view',
            'Category view',
            'Chat view', 'Chat handle', 'Chat transfer',
            'Disputes view', 'Disputes handle',
        ]);

        $executiveRole = Role::create(['name' => 'executive']);
        $executiveRole->givePermissionTo([
            'Chat view', 'Chat handle',
            'Disputes view', 'Disputes handle',
        ]);
    }
}
