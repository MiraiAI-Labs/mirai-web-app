<?php

namespace App\Livewire\Home;

use Livewire\Component;

class Jobs extends Component
{
    public function render()
    {
        return view('livewire.home.jobs')->extends('layouts.home.base', ['activeTab' => 'jobs']);
    }
}
