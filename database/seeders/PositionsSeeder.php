<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = json_decode(file_get_contents(database_path('seeders/json/positions.json')), true);

        foreach ($positions as $position) {
            \App\Models\Position::updateOrCreate(['slug' => $position['slug']], $position);
        }
    }
}
