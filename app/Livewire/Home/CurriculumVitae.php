<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;
use App\Models\CVReview;
use App\Models\JobsAnalysis;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;
use App\Traits\ToastDispatchable;

class CurriculumVitae extends BaseController
{
    use ToastDispatchable;
    use WithFileUploads;

    protected $listeners = [
        'refresh' => 'checkFetched',
        'refreshComponent' => '$refresh',
    ];

    public $cv;
    public $review = "";

    public $loading = false;

    public function mount()
    {
        $this->checkFetched();
    }

    public function checkFetched()
    {
        $user = User::find(auth()->user()->id);
        $position_id = $user->position_id;

        $fetched = JobsAnalysis::fetched($position_id);

        if (!$fetched) {
            redirect()->route('home')->with('toast', ['type' => 'error', 'message' => 'Please generate job analysis first']);
        }

        $this->dispatch('refreshComponent');
    }

    public function updatedCv()
    {
        $this->validate([
            'cv' => 'required|mimes:pdf|max:1024',
        ]);

        $api_url = env("JOB_API_URL", "http://localhost:8001");

        $job_analysis = JobsAnalysis::where('position_id', auth()->user()->position_id)->orderBy('created_at', 'desc')->first();

        $cv_review = CVReview::upload($this->cv, auth()->user());

        $context = ['http' => ['method' => 'GET'], 'ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];
        $context = stream_context_create($context);

        $response = Http::withOptions(['verify' => false])->attach('file', file_get_contents($this->cv->getRealPath()), $this->cv->getClientOriginalName())
            ->attach('job_analysis', file_get_contents("$api_url/$job_analysis->file_path", false, $context), basename($job_analysis->file_path, '.pdf'))
            ->post("$api_url/analyze_cv", [
                'review_id' => $cv_review->id,
            ]);

        if ($response->ok()) {
            $this->toastInfo('Please wait while we analyze your CV');
            $this->loading = true;
        } else {
            $this->toastError('Something went wrong, please try again');
        }
    }

    public function pollingReviewResult()
    {
        $cv_review = CVReview::where('user_id', auth()->id())->orderBy('created_at', 'desc')->first();

        if (!$cv_review) {
            return;
        }

        $this->review = $cv_review->result;

        if ($this->review) {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.home.cv')->extends('layouts.home.base', ['activeTab' => 'cv']);
    }
}
