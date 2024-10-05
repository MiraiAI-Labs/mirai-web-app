<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;
use App\Models\JobsAnalysis;
use App\Models\User;
use App\Traits\ToastDispatchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Home extends BaseController
{
    use ToastDispatchable;

    protected $listeners = [
        'refresh' => 'fetchAnalysis',
        'refreshComponent' => '$refresh',
        'reload' => 'reload',
    ];

    public $fetched = false;
    public $fetching = false;

    public $position_id;

    public $analysis_json;

    public $advice = null;

    public function mount()
    {
        $this->fetchAnalysis();

        $this->advice = Session::get('advice') ?? null;
    }

    public function fetchAdvice()
    {
        if ($this->advice) {
            return;
        }

        if (!$this->analysis_json) {
            return $this->toastError('Analysis not found');
        }

        $api = env('INTERVIEW_API_URL', 'http://localhost:8000');
        $position = User::find(auth()->user()->id)->position->name;
        $body = $this->analysis_json;
        $query = [
            'job_title' => $position
        ];
        $stringifiedQuery = http_build_query($query);
        $response = Http::post($api . "/jobseeker_advice?" . $stringifiedQuery, $body);

        $this->advice = $response->json()['advice'];

        Session::put('advice', $this->advice);

        $this->dispatch('refreshComponent');
    }

    public function reload()
    {
        redirect()->route('home');
    }

    public function fetchAnalysis()
    {
        $user = User::find(auth()->user()->id);

        $this->position_id = $user->position_id;

        if ($this->position_id) {
            $this->fetched = JobsAnalysis::fetched($this->position_id);

            $context = ['http' => ['method' => 'GET'], 'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];
            $context = stream_context_create($context);

            $api_url = env("JOB_API_URL", "http://localhost:8001");
            if ($this->fetched)
                $this->analysis_json = json_decode(file_get_contents($api_url . "/" . JobsAnalysis::where('position_id', $this->position_id)->orderBy('created_at', 'desc')->first()->file_path, false, $context), true);

            $this->dispatch('refreshComponent');
        }
    }

    public function fetch()
    {
        $this->fetching = true;

        if (!$this->position_id)
            return $this->toastError('Position not found');

        try {
            JobsAnalysis::fetch($this->position_id);

            $this->toastInfo('Please wait while we fetch the job lists');
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function pollFetched()
    {
        if (!$this->position_id)
            return;

        $fetchedBefore = $this->fetched;
        $this->fetched = JobsAnalysis::fetched($this->position_id);

        if ($this->fetched && !$fetchedBefore) {
            $this->fetching = false;
            $this->toastSuccess('Fetched successfully');
            redirect()->route('home');
        }
    }

    public function render()
    {
        return view('livewire.home.home')->extends('layouts.home.base', ['activeTab' => 'home']);
    }
}
