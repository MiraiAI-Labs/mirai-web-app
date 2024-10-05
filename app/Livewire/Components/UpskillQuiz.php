<?php

namespace App\Livewire\Components;

use App\Livewire\BaseController;
use App\Models\UpskillQuestionBank;
use App\Models\User;
use App\Models\UserStatistic;
use Illuminate\Support\Facades\Http;
use App\Traits\ToastDispatchable;
use App\Utils\NilaiHelper;

use function PHPSTORM_META\map;

class UpskillQuiz extends BaseController
{
    use ToastDispatchable;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public $questions = [];
    public $answers = [];
    public $feedbacks = [];
    public $nilais = [];
    public $nilaiPerCategory = [];
    public $average = 0;

    public int $currentQuestion = 0;
    public int $totalQuestions = 0;
    public bool $evaluated = false;

    public int $questionPerParameter = 3;

    public $api_url = "";

    public function mount()
    {
        $this->api_url = env("JOB_API_URL", "http://localhost:8001");
    }

    public function start()
    {
        $this->questions = UpskillQuestionBank::getQuestions($this->questionPerParameter);
        $this->totalQuestions = count($this->questions);
    }

    public function next()
    {
        $this->currentQuestion++;
    }

    public function changeQuestion($questionNumber)
    {
        $this->currentQuestion = $questionNumber;
    }

    public function retry()
    {
        $this->answers = [];
        $this->feedbacks = [];
        $this->nilais = [];
        $this->nilaiPerCategory = [];
        $this->average = 0;
        $this->evaluated = false;
        $this->currentQuestion = 0;

        $this->start();

        $this->dispatch('retry-upskill');
    }

    public function forceSubmit()
    {
        for ($i = 0; $i < $this->totalQuestions; $i++) {
            if (!array_key_exists($i, $this->answers)) {
                $this->answers[$i] = "";
            }
        }

        $this->submit(true);
    }

    public function resubmit()
    {
        $this->feedbacks = [];
        $this->nilais = [];
        $this->nilaiPerCategory = [];
        $this->average = 0;
        $this->evaluated = false;
        $this->submit();
    }

    public function submit($force = false)
    {
        if (!$force && count($this->answers) < count($this->questions)) {
            $this->toastError("Please answer all questions before submitting.");
            return;
        }

        $request = [];

        foreach ($this->answers as $key => $answer) {
            $request[] = [
                "question" => $this->questions[$key]->question,
                "answer" => $this->questions[$key]->answer,
                "userAnswer" => $answer,
            ];
        }

        $response = Http::post($this->api_url . "/upskill-judge", $request);

        $response = $response->json();

        $sum = 0;
        foreach ($response as $key => $value) {
            $this->feedbacks[$key] = $value["feedback"];
            $this->nilais[$key] = $value["nilai"];
            $sum += $value["nilai"];

            if (!array_key_exists($this->questions[$key]->skill_parameter->value, $this->nilaiPerCategory)) {
                $this->nilaiPerCategory[$this->questions[$key]->skill_parameter->value] = 0;
            }

            $this->nilaiPerCategory[$this->questions[$key]->skill_parameter->value] += $value["nilai"];
        }

        $this->nilaiPerCategory = array_map(function ($nilai) {
            return $nilai / $this->questionPerParameter;
        }, $this->nilaiPerCategory);

        $this->average = $sum / count($response);

        $this->evaluated = true;

        $this->evaluate();
    }

    public function evaluate()
    {
        $userStatistic = UserStatistic::where('user_id', auth()->id())->first();

        $nilai = new NilaiHelper();

        foreach ($this->nilaiPerCategory as $category => $value) {
            $lcParameter = strtolower($category);

            $nilai->$lcParameter = $value / 10;
        }

        $nilai->exp = 100;

        $userStatistic->evaluate($nilai);
    }

    public function render()
    {
        return view('livewire.components.upskill-quiz');
    }
}
