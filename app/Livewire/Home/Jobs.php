<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;

class Jobs extends BaseController
{
    public function render()
    {
        return view('livewire.home.jobs')->extends('layouts.home.base', ['activeTab' => 'jobs']);
    }
}
