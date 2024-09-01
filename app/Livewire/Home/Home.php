<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;

class Home extends BaseController
{
    public function render()
    {
        return view('livewire.home.home')->extends('layouts.home.base', ['activeTab' => 'home']);
    }
}
