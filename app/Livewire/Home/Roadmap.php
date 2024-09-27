<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;

class Roadmap extends BaseController
{

    protected $listeners = [
        'refresh' => 'updateRoadmap',
        'refreshComponent' => '$refresh',
    ];

    public $roadmap;

    public function mount()
    {
        $this->roadmap = asset(auth()->user()->position->roadmap);
    }

    public function updateRoadmap()
    {
        $this->roadmap = asset(auth()->user()->position->roadmap);

        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        return view('livewire.home.roadmap')->extends('layouts.home.base', ['activeTab' => 'roadmap']);
    }
}
