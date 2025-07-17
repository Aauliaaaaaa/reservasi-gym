<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Cegah duplikat role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin', 'password' => bcrypt('admin123')]
        );
        $admin->assignRole($adminRole);

        // Owner
        $owner = User::firstOrCreate(
            ['email' => 'owner@gmail.com'],
            ['name' => 'Owner', 'password' => bcrypt('owner123')]
        );
        $owner->assignRole($ownerRole);

        // Customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            ['name' => 'Customer', 'password' => bcrypt('customer123')]
        );
        $customer->assignRole($customerRole);

        Log::info('Users and roles seeded successfully.');
    }

}
