<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! $this->command?->getLaravel()->environment('local')) {
            return;
        }

        $email = env('STARTER_ADMIN_EMAIL');
        $password = env('STARTER_ADMIN_PASSWORD');

        if (! $email || ! $password) {
            return;
        }

        User::query()->updateOrCreate(
            ['email' => mb_strtolower($email)],
            [
                'name' => env('STARTER_ADMIN_NAME', 'Local Admin'),
                'password' => Hash::make($password),
                'is_admin' => true,
            ],
        );
    }
}
