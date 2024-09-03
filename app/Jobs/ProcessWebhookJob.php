<?php

namespace App\Jobs;

use App\Models\CVReview;
use App\Models\JobLists;
use App\Models\JobsAnalysis;
use App\Models\Position;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

class ProcessWebhookJob extends SpatieProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public WebhookCall $webhookCall;

    /**
     * Create a new job instance.
     */
    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $req = json_decode($this->webhookCall, true);

        if (!isset($req['payload']['data']) || !isset($req['payload']['event'])) {
            throw new \Exception("Invalid webhook payload");
        }

        $payload = $req['payload']['data'];
        $event = $req['payload']['event'];

        switch ($event) {
            case 'analysis_generated':
                $this->analysisGenerated($payload);
                break;
            case 'cv_analyzed':
                $this->cvAnalyzed($payload);
                break;
            default:
                throw new \Exception("Event not found");
        }
    }

    protected function analysisGenerated($payload)
    {
        if (!isset($payload['jobs_file']) || !isset($payload['analysis_file']) || !isset($payload['jobs_analysis_id']) || !isset($payload['job_lists_id'])) {
            throw new \Exception("Invalid analysis generated payload");
        }

        $jobs_file = $payload['jobs_file'];
        $analysis_file = $payload['analysis_file'];

        $jobs_analysis = JobsAnalysis::find($payload['jobs_analysis_id']);
        $job_lists = JobLists::find($payload['job_lists_id']);

        $jobs_analysis->file_path = $analysis_file;
        $job_lists->file_path = $jobs_file;

        $jobs_analysis->save();
        $job_lists->save();

        return true;
    }

    protected function cvAnalyzed($payload)
    {
        if (!isset($payload['result']) || !isset($payload['review_id'])) {
            throw new \Exception("Invalid analysis generated payload");
        }

        $review_id = $payload['review_id'];
        $result = $payload['result'];

        $cv_review = CVReview::find($review_id);

        $cv_review->result = $result;

        $cv_review->save();

        return true;
    }
}
