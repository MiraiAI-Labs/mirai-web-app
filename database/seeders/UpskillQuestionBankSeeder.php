<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpskillQuestionBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = json_decode(file_get_contents(database_path('seeders/json/upskill_questions.json')), true);

        foreach ($questions as $question) {
            \App\Models\UpskillQuestionBank::updateOrCreate(['question' => $question['question']], $question);
        }
    }
}
