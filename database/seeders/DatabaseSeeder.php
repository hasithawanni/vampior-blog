<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Roles using Spatie
        $adminRole  = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $readerRole = Role::firstOrCreate(['name' => 'reader']);

        // 2. Create the Primary Admin Account
        $admin = User::firstOrCreate(
            ['email' => 'admin@vampior.com'],
            [
                'name'     => 'System Admin',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole($adminRole);

        // 3. Create a Test Editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@vampior.com'],
            [
                'name'     => 'Staff Writer',
                'password' => Hash::make('password123'),
            ]
        );
        $editor->assignRole($editorRole);

        // 4. Create Default Categories
        $categories = ['Technology', 'Lifestyle', 'Design', 'Development'];
        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['name' => $name],
                ['slug' => \Illuminate\Support\Str::slug($name)]
            );
        }
    }
}
