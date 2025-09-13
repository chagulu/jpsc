<?php
namespace App\Jobs;

use App\Models\Candidate;
use App\Models\JetApplicationModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCandidateApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $candidate;
    public $applicationData;

    public function __construct(Candidate $candidate, array $applicationData)
    {
        $this->candidate = $candidate;
        $this->applicationData = $applicationData;
    }

    public function handle()
    {
        // Create application
        $application = JetApplicationModel::create($this->applicationData);

        // Update candidate OTR number
        $this->candidate->update(['otr_no' => $this->applicationData['application_no']]);

        // Update progress bar (optional: queue this too)
        if (method_exists($this, 'updateProgressBar')) {
            // Call updateProgressBar if accessible
            $this->updateProgressBar($application->id, 'profile');
        }
    }
}
