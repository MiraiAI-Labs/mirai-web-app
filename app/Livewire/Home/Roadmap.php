<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;
use App\Models\UserStatistic;
use App\Utils\NilaiHelper;
use Illuminate\Support\Facades\Http;

class Roadmap extends BaseController
{

    protected $listeners = [
        'refresh' => 'updateRoadmap',
        'refreshComponent' => '$refresh',
    ];

    public $jsons;
    public $json;
    public $roadmap;

    public $useJson = false;

    public $quiz = null;

    public function mount()
    {
        $this->roadmap = asset(auth()->user()->position->roadmap);

        $this->jsons = [
            "Frontend Developer" => public_path('roadmaps/json/frontend.json'),
            "Backend Developer" => public_path('roadmaps/json/backend.json'),
            "Fullstack Developer" => public_path('roadmaps/json/full-stack.json'),
            "DevOps Engineer" => public_path('roadmaps/json/devops.json'),
            "QA Engineer" => public_path('roadmaps/json/qa.json'),
            "Product Manager" => public_path('roadmaps/json/product-manager.json'),
            "UI/UX Designer" => public_path('roadmaps/json/ux-design.json'),
            "Data Scientist" => public_path('roadmaps/json/ai-ds.json'),
            "Data Analyst" => public_path('roadmaps/json/data-analyst.json'),
        ];

        if (array_key_exists(auth()->user()->position->name, $this->jsons)) {
            $this->json = json_decode(file_get_contents($this->jsons[auth()->user()->position->name]), true);
            $this->useJson = true;
        }
    }

    public function updateRoadmap()
    {
        $this->roadmap = asset(auth()->user()->position->roadmap);

        $this->dispatch('refreshComponent');
    }

    public function generateQuiz($id)
    {
        $api_url = env("INTERVIEW_API_URL", "http://localhost:8000");

        $response = Http::post($api_url . "/roadmap_quiz", [
            'title' => $this->json[$id]['title'] ?? '',
            'description' => $this->json[$id]['description'] ?? '',
        ]);

        $quiz = $response->json();

        $this->quiz = [
            'id' => $id,
            'title' => $this->json[$id]['title'] ?? '',
            'question' => $quiz['question'],
            'choices' => $quiz['choices'],
            'answer' => md5($quiz['choices'][$quiz['answer']] . base64_decode(substr(env('APP_KEY'), 7))),
        ];

        $this->dispatch('openQuiz');
    }

    public function choseAnswer($index)
    {
        $userChoseRight = $this->quiz['answer'] == md5($this->quiz['choices'][$index] . base64_decode(substr(env('APP_KEY'), 7)));

        $userStatistic = UserStatistic::where('user_id', auth()->id())->first();

        $nilai = new NilaiHelper();

        if ($userChoseRight) {
            $this->dispatch('rightAnswer');

            $nilai->technical = 10;
            $nilai->exp = 5;
        } else {
            $this->dispatch('wrongAnswer');

            $nilai->technical = 0;
        }

        $userStatistic->evaluate($nilai);
        // reset quiz
        $this->quiz = null;
    }

    public function render()
    {
        return view('livewire.home.roadmap')->extends('layouts.home.base', ['activeTab' => 'roadmap']);
    }
}
