<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Traits\ToastDispatchable;

class UserClass extends BaseController
{
    use ToastDispatchable;

    protected $listeners = [
        'refresh-user-class' => 'refreshUserClass',
        'refresh-only-user-class' => '$refresh',
    ];

    public $class;

    public $inHome = true;

    public function refreshUserClass()
    {
        $this->dispatch('refresh-only-user-class');
        $this->dispatch('archetype-quiz-completed');
    }

    public function render()
    {
        return view('livewire.components.user-class');
    }
}
