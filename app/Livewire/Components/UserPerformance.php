<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Traits\ToastDispatchable;

class UserPerformance extends BaseController
{
    use ToastDispatchable;

    public $class;
    public $id;

    public $targets = [
        "Frontend Developer" => [
            "motivation" => 8,
            "cognitive" => 7,
            "scholastic" => 6,
            "technical" => 9,
            "interpersonal" => 7,
            "eq" => 7,
            "creativity" => 9,
            "adaptability" => 8
        ],
        "Backend Developer" => [
            "motivation" => 8,
            "cognitive" => 8,
            "scholastic" => 7,
            "technical" => 9,
            "interpersonal" => 6,
            "eq" => 6,
            "creativity" => 7,
            "adaptability" => 7
        ],
        "Fullstack Developer" => [
            "motivation" => 9,
            "cognitive" => 8,
            "scholastic" => 7,
            "technical" => 9,
            "interpersonal" => 7,
            "eq" => 7,
            "creativity" => 8,
            "adaptability" => 8
        ],
        "DevOps Engineer" => [
            "motivation" => 8,
            "cognitive" => 8,
            "scholastic" => 7,
            "technical" => 9,
            "interpersonal" => 6,
            "eq" => 6,
            "creativity" => 6,
            "adaptability" => 8
        ],
        "SecOps Engineer" => [
            "motivation" => 7,
            "cognitive" => 8,
            "scholastic" => 7,
            "technical" => 9,
            "interpersonal" => 5,
            "eq" => 5,
            "creativity" => 6,
            "adaptability" => 7
        ],
        "QA Engineer" => [
            "motivation" => 8,
            "cognitive" => 7,
            "scholastic" => 7,
            "technical" => 8,
            "interpersonal" => 6,
            "eq" => 6,
            "creativity" => 6,
            "adaptability" => 7
        ],
        "Project Manager" => [
            "motivation" => 9,
            "cognitive" => 8,
            "scholastic" => 7,
            "technical" => 7,
            "interpersonal" => 9,
            "eq" => 9,
            "creativity" => 8,
            "adaptability" => 8
        ],
        "Product Manager" => [
            "motivation" => 9,
            "cognitive" => 8,
            "scholastic" => 7,
            "technical" => 7,
            "interpersonal" => 9,
            "eq" => 9,
            "creativity" => 9,
            "adaptability" => 8
        ],
        "UI/UX Designer" => [
            "motivation" => 8,
            "cognitive" => 7,
            "scholastic" => 6,
            "technical" => 8,
            "interpersonal" => 7,
            "eq" => 7,
            "creativity" => 10,
            "adaptability" => 8
        ],
        "Data Scientist" => [
            "motivation" => 8,
            "cognitive" => 9,
            "scholastic" => 9,
            "technical" => 8,
            "interpersonal" => 6,
            "eq" => 6,
            "creativity" => 8,
            "adaptability" => 8
        ],
        "Data Analyst" => [
            "motivation" => 8,
            "cognitive" => 8,
            "scholastic" => 8,
            "technical" => 8,
            "interpersonal" => 6,
            "eq" => 6,
            "creativity" => 7,
            "adaptability" => 7
        ],
        "Data Engineer" => [
            "motivation" => 8,
            "cognitive" => 8,
            "scholastic" => 7,
            "technical" => 9,
            "interpersonal" => 6,
            "eq" => 6,
            "creativity" => 7,
            "adaptability" => 7
        ]
    ];

    public $target = [];

    public function mount()
    {
        $this->id = str()->random();

        $class = auth()->user()->position->name;

        $this->target = $this->targets[$class] ?? [
            "motivation" => 0,
            "cognitive" => 0,
            "scholastic" => 0,
            "technical" => 0,
            "interpersonal" => 0,
            "eq" => 0,
            "creativity" => 0,
            "adaptability" => 0
        ];
    }

    public function render()
    {
        return view('livewire.components.user-performance');
    }
}
