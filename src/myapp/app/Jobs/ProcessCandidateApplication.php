<?php
namespace App\Jobs;

use App\Models\Candidate;
use App\Models\JetApplicationModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;

class ProcessCandidateApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $candidate;
    public $applicationData;

    /**
     * Create a new job instance.
     */
    public function __construct(Candidate $candidate, array $applicationData)
    {
        $this->candidate = $candidate;
        $this->applicationData = $applicationData;
    }

    /**
     * Execute the job.
     */
    public function handle()
{
    // Insert application
    $application = JetApplicationModel::create($this->applicationData); // keys match $fillable [2]

    // Update candidate OTR (optional if already set)
    $this->candidate->update(['otr_no' => $this->applicationData['application_no']]);

    // Prepare candidate verification updates
    $updateData = [];

    if (!empty($this->applicationData['email'])) {
        $updateData['email_verified_at'] = now();
    }
    if (!empty($this->applicationData['mobile_no'])) { // use mobile_no, not mobile_number
        $updateData['mobile_verified_at'] = now();
    }
    if ($updateData) {
        $this->candidate->update($updateData);
    }

    // Optional: update progress
    if (method_exists($this, 'updateProgressBar')) {
        $this->updateProgressBar($application->id, 'profile');
    }

    // Optional: clear candidate-specific preview key if used
    $sessionKey = 'preview_application_' . $this->candidate->id;
    if (Session::has($sessionKey)) {
        Session::forget($sessionKey);
    }
}

}
