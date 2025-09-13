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
        // 1️⃣ Insert application into DB
        $application = JetApplicationModel::create($this->applicationData);

        // 2️⃣ Update candidate OTR number
        $this->candidate->update(['otr_no' => $this->applicationData['application_no']]);

        // 3️⃣ Optional: Update progress bar
        if (method_exists($this, 'updateProgressBar')) {
            $this->updateProgressBar($application->id, 'profile');
        }

        // 4️⃣ Clear session preview for this candidate
        // Note: only clear if using session keys like 'preview_application_<candidate_id>'
        $sessionKey = 'preview_application_' . $this->candidate->id;
        if (Session::has($sessionKey)) {
            Session::forget($sessionKey);
        }
    }
}
