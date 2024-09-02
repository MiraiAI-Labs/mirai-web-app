<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Traits\ToastDispatchable;

class Quiz extends BaseController
{
    use ToastDispatchable;

    protected $listeners = [
        'refresh' => '$refresh',
        'nextQuestion' => 'nextQuestion'
    ];

    public $questions = [];

    public bool $loading = false;
    public bool $loaded = false;
    public int $currentQuestion = 0;

    public $api_url = "";
    public $positionName = "";

    public function mount()
    {
        $this->api_url = env("INTERVIEW_API_URL", "http://localhost:8000");

        $user = User::find(auth()->id());

        $this->positionName = $user->position->name;
    }

    public function start()
    {
        $stringifiedQueries = http_build_query([
            'position' => $this->positionName,
        ]);

        $response = Http::get("$this->api_url/generate_quiz?$stringifiedQueries");

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
            $this->currentQuestion = 0;
            $this->loaded = false;
            $this->loading = false;
            $this->dispatch('quizCompleted');
            return;
        }

        $this->currentQuestion++;
    }

    public function timeout()
    {
        $this->toastError('Quiz timed out');
        $this->currentQuestion = 0;
        $this->loaded = false;
        $this->loading = false;
        $this->dispatch('quizCompleted');
    }

    public function render()
    {
        return view('livewire.home.quiz')->extends('layouts.home.base', ['activeTab' => 'quiz']);
    }
}
