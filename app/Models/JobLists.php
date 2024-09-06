<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class JobLists extends Model
{
    protected $table = 'job_lists';

    public $incrementing = true;

    protected $fillable = ['file_path'];

    public static function fetched($position_id)
    {
        $job_lists = JobLists::where('position_id', $position_id)->orderBy('created_at', 'desc')->first();

        if ($job_lists && $job_lists->file_path && $job_lists->created_at->diffInDays(now()) < 7) {
            return true;
        }

        return false;
    }

    public static function fetch($position_id): bool
    {
        $position = Position::find($position_id);

        if (!$position) {
            throw new \Exception("Position not found");
        }

        if (JobLists::fetched($position_id)) {
            throw new \Exception("Job lists already fetched");
        }

        $api_url = env("JOB_API_URL", "http://localhost:8001");

        $job_analysis = new JobsAnalysis();
        $job_analysis->position_id = $position_id;

        $job_analysis->save();

        $job_list = new JobLists();
        $job_list->position_id = $position_id;

        $job_list->save();

        $response = Http::withOptions(['verify' => false])->post("$api_url/generate_analysis", [
            'text' => $position->name,
            'jobs_analysis_id' => $job_analysis->id,
            'job_lists_id' => $job_list->id,
        ]);

        switch ($response->status()) {
            case 404:
                throw new \Exception("Internal server error: API not found");
            case 422:
                throw new \Exception("Internal server error: Bad request");
            case 500:
                throw new \Exception("Internal server error: API error");
        }

        $response_data = $response->json();

        $jobs_file = $response_data['jobs_file'];
        $analysis_file = $response_data['analysis_file'];

        $job_analysis = new JobsAnalysis();
        $job_analysis->file_path = $analysis_file;
        $job_analysis->position_id = $position_id;

        $job_analysis->save();

        $job_list = new JobLists();
        $job_list->file_path = $jobs_file;
        $job_list->position_id = $position_id;

        $job_list->save();

        return true;
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
