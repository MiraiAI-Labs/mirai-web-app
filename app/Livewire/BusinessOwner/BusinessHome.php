<?php

namespace App\Livewire\BusinessOwner;

use App\Livewire\BaseController;
use App\Models\User;
use App\Traits\ToastDispatchable;

class BusinessHome extends BaseController
{
    use ToastDispatchable;

    public $veterans = [];

    public function mount()
    {
        $this->veterans = User::getByHighestExp(5);
        // find user with highest exps

    }

    public function render()
    {
        return view('livewire.business-owner.home')->extends('layouts.home.base', ['activeTab' => 'business-home']);
    }
}
