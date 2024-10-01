<?php

namespace App\Models;

use App\Enums\SkillParameterEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class UpskillQuestionBank extends Model
{
    protected $table = 'upskill_question_bank';

    public $incrementing = true;

    protected $fillable = ['skill_parameter', 'question', 'answer'];

    protected $casts = [
        'skill_parameter' => SkillParameterEnum::class,
    ];

    public static function getRandomizedQuestions($skillParameter, $limit = 5)
    {
        $result = self::select('id', 'question')->where('skill_parameter', $skillParameter)->inRandomOrder()->limit($limit)->get();
        return $result;
    }

    public static function getQuestions($perParameter = 3): Collection
    {
        $skillParameters = SkillParameterEnum::toArray();

        $questions = collect();

        foreach ($skillParameters as $skillParameter) {
            $questions = $questions->merge(self::getRandomizedQuestions($skillParameter, $perParameter));
        }

        $questions = $questions->shuffle();

        return $questions;
    }
}
