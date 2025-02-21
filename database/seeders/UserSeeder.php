<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Master Admin',
            'email' => 'masteradmin@htt.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Change this to a secure password
            'remember_token' => Str::random(10),
            'archived' => false, // Assuming this is a boolean field
        ]);

        $user->assignRole('admin');
        $user->givePermissionTo('manage users');
        $user->givePermissionTo('edit tasks');
        $user->givePermissionTo('delete tasks');
        $user->givePermissionTo('create tasks');
        $user->givePermissionTo('manage legends');

        User::factory(10)->create(); // This will generate 10 random users if you have a factory
    }
}
