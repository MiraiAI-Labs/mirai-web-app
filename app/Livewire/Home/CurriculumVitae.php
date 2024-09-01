<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;

class CurriculumVitae extends BaseController
{
    public function render()
    {
        return view('livewire.home.cv')->extends('layouts.home.base', ['activeTab' => 'cv']);
    }
}
