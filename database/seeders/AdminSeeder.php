<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the admin user.
     * Credentials: admin@amarmart.com / password
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@amarmart.com'],
            [
                'name'       => 'Admin',
                'email'      => 'admin@amarmart.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Admin user seeded: admin@amarmart.com / password');
    }
}
