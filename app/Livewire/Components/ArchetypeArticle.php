<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Traits\ToastDispatchable;
use Illuminate\Support\Str;

class ArchetypeArticle extends BaseController
{
    use ToastDispatchable;

    public function render()
    {
        return view('livewire.components.archetype-article');
    }
}
