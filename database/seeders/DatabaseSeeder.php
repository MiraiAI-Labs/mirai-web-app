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
            PositionsSeeder::class,
        ],
        'staging' => [
            RoleSeeder::class,
            UserSeeder::class,
            PositionsSeeder::class,
        ],
        'production' => [
            RoleSeeder::class,
            UserSeeder::class,
            PositionsSeeder::class,
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
