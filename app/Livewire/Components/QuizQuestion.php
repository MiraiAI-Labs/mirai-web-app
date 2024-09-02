<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;

class QuizQuestion extends BaseController
{
    protected $listeners = [
        'refresh' => '$refresh',
        'quizCompleted' => 'quizCompleted'
    ];

    public $question;
    public $options;
    public $answer;
    public $number;

    public bool $chosen = false;
    public $chosenOption = -1;

    public $radioStyle = [];
    public $labelStyle = [];

    public function mount()
    {
        $this->radioStyle = array_fill(0, count($this->options), '');
        $this->labelStyle = $this->radioStyle;
    }

    public function updatedChosenOption($value)
    {
        $this->chosen = true;

        $salt = base64_decode(substr(env('APP_KEY'), 7));

        foreach ($this->options as $key => $option) {
            $rightOption = md5($option . $salt) == $this->answer;
            $this->radioStyle[$key] = $rightOption ? 'checked-success' : 'checked-error';

            if ($key == $value) {
                $this->labelStyle[$key] = $rightOption ? 'input-success' : 'input-error';
            }
        }
    }

    public function quizCompleted()
    {
        $this->chosen = false;
        $this->chosenOption = -1;
        $this->radioStyle = array_fill(0, count($this->options), '');
        $this->labelStyle = $this->radioStyle;
    }

    public function render()
    {
        return view('livewire.components.quiz-question');
    }
}
