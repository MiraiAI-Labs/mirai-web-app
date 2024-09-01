<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;

class Sidebar extends BaseController
{
    public $activeTab = 'home';

    public function render()
    {
        return view('layouts.home.sidebar');
    }
}
