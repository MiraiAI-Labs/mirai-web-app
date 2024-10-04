<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::createIfNotExists([
            'name' => 'Business Owner',
            'email' => 'business@owner.com',
            'password' => 'password',
        ]);

        $user->assignRole('business-owner');
    }
}
