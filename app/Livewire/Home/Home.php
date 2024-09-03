<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;
use App\Models\JobsAnalysis;
use App\Models\User;
use App\Traits\ToastDispatchable;

class Home extends BaseController
{
    use ToastDispatchable;

    public $fetched = false;
    public $fetching = false;

    public $position_id;

    public $analysis_json;

    public function mount()
    {
        $user = User::find(auth()->user()->id);

        $this->position_id = $user->position_id;

        if ($this->position_id)
            $this->fetched = JobsAnalysis::fetched($this->position_id);


        $api_url = env("JOB_API_URL", "http://localhost:8001");
        if ($this->fetched)
            $this->analysis_json = json_decode(file_get_contents($api_url . "/" . JobsAnalysis::where('position_id', $this->position_id)->orderBy('created_at', 'desc')->first()->file_path), true);
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
        }
    }

    public function render()
    {
        return view('livewire.home.home')->extends('layouts.home.base', ['activeTab' => 'home']);
    }
}
