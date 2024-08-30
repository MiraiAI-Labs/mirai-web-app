<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private function randomPassword($length = 8): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->environment('local')) {
            User::factory(10)->create();

            $user = User::createIfNotExists([
                'name' => 'User',
                'email' => 'user@user.com',
                'password' => 'password',
            ]);

            ($user) ? $user->assignRole('user') : null;
            ($user) ? $this->command->info("User created with email: $user->email and password: password") : null;

            $admin = User::createIfNotExists([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => 'password',
            ]);

            ($admin) ? $admin->assignRole('admin') : null;
            ($admin) ? $this->command->info("Admin created with email: $admin->email and password: password") : null;
        } else if (app()->environment('staging') || app()->environment('production')) {
            $userPassword = $this->randomPassword(app()->environment('production') ? 16 : 8);

            $user = User::createIfNotExists([
                'name' => 'User',
                'email' => 'user@user.com',
                'password' => $userPassword,
            ]);

            ($user) ? $user->assignRole('user') : null;
            ($user) ? $this->command->info("User created with email: $user->email and password: $userPassword") : null;

            $adminPassword = $this->randomPassword(app()->environment('production') ? 16 : 8);

            $admin = User::createIfNotExists([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => $adminPassword,
            ]);

            ($admin) ? $admin->assignRole('admin') : null;
            ($admin) ? $this->command->info("Admin created with email: $admin->email and password: $adminPassword") : null;
        } else {
            $this->command->warn('No seeder for this environment');
        }
    }
}
