<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Traits\ToastDispatchable;

class UserPerformance extends BaseController
{
    use ToastDispatchable;

    public $class;
    public $id;

    public function mount()
    {
        $this->id = str()->random();
    }

    public function render()
    {
        return view('livewire.components.user-performance');
    }
}
