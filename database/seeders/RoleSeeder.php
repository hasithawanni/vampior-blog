<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Roles
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);
        $reader = Role::create(['name' => 'reader']);

        // 2. Create Permissions (Optional but good practice)
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'publish posts']);

        // 3. Assign Permissions to Roles
        $admin->givePermissionTo(Permission::all());
        $editor->givePermissionTo(['create posts', 'edit posts', 'publish posts']);
        // Reader gets no special permissions, they can just "view"
    }
}