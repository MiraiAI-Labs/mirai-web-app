<?php

namespace App\Livewire;

use Livewire\Component;

class BaseController extends Component
{
    protected $listeners = [
        'refresh' => '$refresh'
    ];
}
