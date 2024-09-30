<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;
use App\Models\JobsAnalysis;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Traits\ToastDispatchable;

class Quiz extends BaseController
{
    use ToastDispatchable;

    protected $listeners = [
        'refresh' => 'checkFetched',
        'refreshComponent' => '$refresh',
    ];

    public function mount()
    {
        $this->checkFetched();
    }

    public function checkFetched()
    {
        $user = User::find(auth()->user()->id);
        $position_id = $user->position_id;

        $fetched = JobsAnalysis::fetched($position_id);

        if (!$fetched) {
            redirect()->route('home')->with('toast', ['type' => 'error', 'message' => 'Please generate job analysis first']);
        }

        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        return view('livewire.home.quiz')->extends('layouts.home.base', ['activeTab' => 'quiz']);
    }
}
