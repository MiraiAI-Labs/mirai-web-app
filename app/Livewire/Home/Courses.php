<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;
use Illuminate\Support\Facades\Http;

class Courses extends BaseController
{
    protected $listeners = [
        'refresh' => 'updateCourses',
        'refreshComponent' => '$refresh',
    ];

    public $courses = [];
    public $endpoint = "https://www.udemy.com/api-2.0/";
    public $page = 1;
    public $maxPage = 1;
    public $count = 0;
    public $page_size = 12;

    public function mount()
    {
        $this->fetchCourses();
    }

    public function changePage($page)
    {
        $this->page = $page;
        $this->fetchCourses();

        $this->dispatch('log', $this->maxPage);
    }

    public function fetchCourses()
    {
        $headers = ['Authorization' => 'Basic ' . base64_encode(env('UDEMY_CLIENT_ID') . ':' . env('UDEMY_CLIENT_SECRET'))];
        $queries = [
            'search' => auth()->user()->position->name,
            'ordering' => 'most-reviewed',
            'page_size' => $this->page_size,
            'page' => $this->page,
        ];

        $stringifiedQueries = http_build_query($queries);

        $response = Http::withHeaders($headers)
            ->get($this->endpoint . 'courses?' . $stringifiedQueries)
            ->json();

        // after fetch
        if ($this->count == 0) {
            $this->count = $response['count'];

            $this->maxPage = floor($this->count / $this->page_size);
        }

        $this->courses = $response['results'];
    }

    public function updateCourses()
    {
        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        return view('livewire.home.courses')->extends('layouts.home.base', ['activeTab' => 'courses']);
    }
}
