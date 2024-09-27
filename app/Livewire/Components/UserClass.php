<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Traits\ToastDispatchable;

class UserClass extends BaseController
{
    use ToastDispatchable;

    public $class;

    public function render()
    {
        return view('livewire.components.user-class');
    }
}
