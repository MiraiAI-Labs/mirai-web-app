<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Models\UpskillQuestionBank;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Traits\ToastDispatchable;

class UpskillQuiz extends BaseController
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
        $this->questions = UpskillQuestionBank::getQuestions();
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

        dd($this->answers);
    }

    public function render()
    {
        return view('livewire.components.upskill-quiz');
    }
}
