<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArchetypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archetypes = json_decode(file_get_contents(database_path('seeders/json/archetypes.json')), true);

        foreach ($archetypes as $archetype) {
            \App\Models\Archetype::updateOrCreate(['name' => $archetype['name']], $archetype);
        }
    }
}
