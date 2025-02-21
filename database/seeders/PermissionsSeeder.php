<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['manage users', 'edit tasks', 'delete tasks', 'create tasks', 'manage legends'];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
