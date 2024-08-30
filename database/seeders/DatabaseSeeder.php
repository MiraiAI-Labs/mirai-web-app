<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $seeders = [
        'local' => [
            RoleSeeder::class,
            UserSeeder::class,
        ],
        'staging' => [
            RoleSeeder::class,
            UserSeeder::class,
        ],
        'production' => [
            RoleSeeder::class,
            UserSeeder::class,
        ],
    ];
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!array_key_exists(app()->environment(), $this->seeders)) {
            return;
        }

        $this->call($this->seeders[app()->environment()]);
    }
}
