<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Traits\ToastDispatchable;
use Illuminate\Support\Str;

class Bar extends BaseController
{
    use ToastDispatchable;

    public $data;
    public $id;
    public $isVertical = true;
    public $sort = true;
    public $descending = true;
    public $class;

    public function mount()
    {
        if ($this->id == null)
            $this->id = (string) Str::uuid();
    }

    public function render()
    {
        return view('livewire.components.bar');
    }
}
