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
        $pelatihRole = Role::firstOrCreate(['name' => 'pelatih']);

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin', 'password' => bcrypt('admin123'), 'email_verified_at' => now()],
        );
        $admin->assignRole($adminRole);

        // Owner
        $owner = User::firstOrCreate(
            ['email' => 'owner@gmail.com'],
            ['name' => 'Owner', 'password' => bcrypt('owner123'), 'email_verified_at' => now()]
        );
        $owner->assignRole($ownerRole);

        // Customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@gmail.com'],
            ['name' => 'Customer', 'password' => bcrypt('customer123'), 'email_verified_at' => now()]
        );
        $customer->assignRole($customerRole);

        Log::info('Users and roles seeded successfully.');
    }

}
