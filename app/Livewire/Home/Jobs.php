<?php

namespace App\Livewire\Home;

use App\Livewire\BaseController;
use App\Models\JobLists;
use App\Models\User;

class Jobs extends BaseController
{
    public $position_id;

    public $jobs = [];
    public $current_job = 0;

    public $title;
    public $date_posted;
    public $company;
    public $location;
    public $job_type;
    public $description;
    public $url;
    public $company_url;
    public $salary;

    public function mount()
    {
        $user = User::find(auth()->user()->id);

        $this->position_id = $user->position_id;

        $api_url = env("JOB_API_URL", "http://localhost:8001");
        $file_path = JobLists::where('position_id', $this->position_id)->orderBy('created_at', 'desc')->first()->file_path;

        if ($this->position_id && $file_path) {
            $file = fopen("$api_url/$file_path", 'r');
            fgetcsv($file);

            while (!feof($file)) {
                $line = fgetcsv($file);
                if ($line) {
                    $this->jobs[] = [
                        'id' => $line[0],
                        'company' => $line[5],
                        'title' => $line[4],
                        'job_type' => $line[7],
                        'date_posted' => $line[8],
                        'location' => $line[6],
                        'description' => $line[20],
                        'url' => $line[2],
                        'company_url' => $line[21],
                        'salary' => $line[9],
                    ];
                }
            }

            fclose($file);
        }
    }

    public function changeJob($job_id)
    {
        $this->current_job = $job_id;

        $job = $this->jobs[array_search($job_id, array_column($this->jobs, 'id'))];

        $this->title = $job['title'];
        $this->date_posted = $job['date_posted'];
        $this->company = $job['company'];
        $this->location = $job['location'];
        $this->job_type = $job['job_type'];
        $this->description = $job['description'];
        $this->url = $job['url'];
        $this->company_url = $job['company_url'];
        $this->salary = $job['salary'];
    }

    public function render()
    {
        return view('livewire.home.jobs')->extends('layouts.home.base', ['activeTab' => 'jobs']);
    }
}
