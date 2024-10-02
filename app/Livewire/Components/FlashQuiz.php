<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Models\JobsAnalysis;
use App\Models\User;
use App\Models\UserStatistic;
use Illuminate\Support\Facades\Http;
use App\Traits\ToastDispatchable;
use App\Utils\NilaiHelper;

class FlashQuiz extends BaseController
{
    use ToastDispatchable;

    protected $listeners = [
        'nextQuestion' => 'nextQuestion',
        'refresh' => '$refresh',
        'right-answer-flash-quiz' => 'rightAnswer',
        'quizCompleted' => 'evaluate',
    ];

    public $questions = [];

    public bool $loading = false;
    public bool $loaded = false;
    public bool $completed = false;
    public int $currentQuestion = 0;

    public int $rightAnswers = 0;

    public $api_url = "";
    public $positionName = "";

    public function mount()
    {
        $this->api_url = env("INTERVIEW_API_URL", "http://localhost:8000");

        $user = User::find(auth()->id());

        $this->positionName = $user->position->name;
    }

    public function rightAnswer()
    {
        $this->rightAnswers++;
    }

    public function start()
    {
        $this->completed = false;
        $stringifiedQueries = http_build_query([
            'position' => $this->positionName,
        ]);

        $response = Http::withOptions(['verify' => false])->get("$this->api_url/generate_quiz?$stringifiedQueries");

        if (!$response->ok()) {
            $this->toastError('Failed to fetch quiz questions');
            return;
        }

        $this->questions = $response->json()['quiz'];

        $this->loaded = true;

        $this->dispatch('questions-loaded');
    }

    public function nextQuestion()
    {
        if ($this->currentQuestion == count($this->questions) - 1) {
            $this->toastSuccess('Quiz completed!');
            $this->completed = true;
            $this->dispatch('quizCompleted');
            return;
        }

        $this->currentQuestion++;
    }

    public function evaluate()
    {
        $userStatistic = UserStatistic::where('user_id', auth()->id())->first();

        $nilai = new NilaiHelper();

        $nilai->cognitive = $this->rightAnswers;
        $nilai->exp = 50;

        $userStatistic->evaluate($nilai);
    }

    public function timeout()
    {
        $this->toastError('Quiz timed out');
        $this->completed = true;
        $this->dispatch('quizCompleted');
    }

    public function done()
    {
        $this->loaded = false;
        $this->loading = false;
        $this->completed = false;

        $this->currentQuestion = 0;
        $this->rightAnswers = 0;
        $this->questions = [];
    }

    public function render()
    {
        return view('livewire.components.flash-quiz');
    }
}
