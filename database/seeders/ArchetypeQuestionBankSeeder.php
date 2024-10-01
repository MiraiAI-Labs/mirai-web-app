<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ArchetypeQuestionBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = json_decode(file_get_contents(database_path('seeders/json/archetype_questions.json')), true);

        foreach ($questions as $question) {
            // find the archetype id
            $archetype = \App\Models\Archetype::where('name', $question['archetype'])->first();

            // check if archetype is not found
            if (!$archetype) {
                $this->command->error('Archetype not found: ' . $question['archetype']);
                continue;
            }

            \App\Models\ArchetypeQuestionBank::updateOrCreate(['question' => $question['question']], [
                'archetype_id' => $archetype->id,
                'question' => $question['question'],
            ]);
        }
    }
}
