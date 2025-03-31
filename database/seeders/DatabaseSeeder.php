<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
//        \App\Models\User::create([
//            'name' => 'Super Admin',
//            'email' => 'admin@ecobillcarwash.com',
//            'password' => bcrypt('admin1234'),
//            'role' => 'superadmin',
//        ]);
        \App\Models\User::create([
            'name' => 'Eco Boss',
            'email' => 'tenantadmin@ecowash.com',
            'password' => bcrypt('secret123'),
            'role' => 'tenant_admin',
        ]);


    }
}
