<?php

namespace App\Livewire\Home;

use Livewire\Component;

class CurriculumVitae extends Component
{
    public function render()
    {
        return view('livewire.home.cv')->extends('layouts.home.base', ['activeTab' => 'cv']);
    }
}
