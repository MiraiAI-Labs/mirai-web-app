<?php

namespace App\Models;

use App\Enums\SkillParameterEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ArchetypeQuestionBank extends Model
{
    protected $table = 'archetype_question_bank';

    public $incrementing = true;

    protected $fillable = ['archetype_id', 'question'];

    public function archetype()
    {
        return $this->belongsTo(Archetype::class);
    }

    public static function getRandomizedQuestions($archetypeId, $limit = 5)
    {
        $result = self::select('id', 'question')->where('archetype_id', $archetypeId)->inRandomOrder()->limit($limit)->get();
        return $result;
    }

    public static function getQuestions(): Collection
    {
        $perArchetype = 5;

        $archetypes = Archetype::getBaseArchetypes();

        $questions = collect();

        foreach ($archetypes as $archetype) {
            $questions = $questions->merge(self::getRandomizedQuestions($archetype->id, $perArchetype));
        }

        $questions = $questions->shuffle();

        return $questions;
    }
}
