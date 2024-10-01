<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Models\ArchetypeQuestionBank;
use App\Models\UpskillQuestionBank;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Traits\ToastDispatchable;
use Illuminate\Support\Facades\Auth;

class ArchetypeQuiz extends BaseController
{
    use ToastDispatchable;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public $questions = [];
    public $answers = [];
    public int $currentQuestion = 0;
    public int $totalQuestions = 0;

    public $api_url = "";

    public function mount()
    {
        $this->api_url = env("INTERVIEW_API_URL", "http://localhost:8000");
    }

    public function start()
    {
        $this->questions = ArchetypeQuestionBank::getQuestions();
        $this->totalQuestions = count($this->questions);
    }

    public function next()
    {
        $this->currentQuestion++;
    }

    public function changeQuestion($questionNumber)
    {
        $this->currentQuestion = $questionNumber;
    }

    public function submit()
    {
        if (count($this->answers) < count($this->questions)) {
            $this->toastError("Please answer all questions before submitting.");
            return;
        }

        $this->getArchetype();
    }

    public function forceSubmit()
    {
        for ($i = 0; $i < $this->totalQuestions; $i++) {
            if (!array_key_exists($i, $this->answers)) {
                $this->answers[$i] = 0;
            }
        }

        $this->getArchetype();
    }

    public function getArchetype()
    {
        $archetypes = [];

        foreach ($this->questions as $key => $question) {
            if (!array_key_exists($question->archetype->id, $archetypes)) {
                $archetypes[$question->archetype->id] = 0;
            }

            $archetypes[$question->archetype->id] += $this->answers[$key];
        }

        arsort($archetypes);

        Auth::user()->userStatistic->archetype_id = array_key_first($archetypes);
        Auth::user()->userStatistic->save();

        $this->toastSuccess("Archetype quiz completed successfully.");

        $this->dispatch('refresh-user-class');
    }

    public function randomizeAnswers()
    {
        for ($i = 0; $i < $this->totalQuestions; $i++) {
            $this->answers[$i] = rand(-5, 5);
        }
    }

    public function render()
    {
        return view('livewire.components.archetype-quiz');
    }
}
