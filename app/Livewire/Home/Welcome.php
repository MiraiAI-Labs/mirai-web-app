<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;
use App\Traits\ToastDispatchable;

class Welcome extends BaseController
{
    use ToastDispatchable;

    public function render()
    {
        return view('livewire.home.welcome')->extends('layouts.app');
    }
}
