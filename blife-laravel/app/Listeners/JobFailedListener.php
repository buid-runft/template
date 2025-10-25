<?php

namespace App\Listeners;

use App\Jobs\FailedJobAlertJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Events\JobFailed;

class JobFailedListener implements ShouldQueue
{
    public function handle(JobFailed $event): void
    {
        FailedJobAlertJob::dispatch([
            'id' => $event->job->getJobId(),
            'connection' => $event->connectionName,
            'queue' => $event->job->getQueue(),
            'exception' => $event->exception->getMessage(),
            'failed_at' => now(),
        ]);
    }
}
