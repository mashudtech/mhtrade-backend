<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mhtradecap.com'],
            [
                'name'     => 'MH Trade Admin',
                'email'    => 'admin@mhtradecap.com',
                'password' => Hash::make('Admin@MHT2026!'),
                'role'     => 'super_admin',
            ]
        );

        $this->command->info('✅ Admin user seeded: admin@mhtradecap.com / Admin@MHT2026!');
    }
}
