<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckFailedJobsCommand extends Command
{
    protected $signature = 'monitor:failed-jobs';
    protected $description = 'Check for failed jobs and send alerts';

    public function handle(): int
    {
        $failedJobs = DB::table('failed_jobs')
            ->where('failed_at', '>', now()->subMinutes(60))
            ->get();

        if ($failedJobs->count() > 0) {
            foreach ($failedJobs as $job) {
                \App\Jobs\FailedJobAlertJob::dispatch((array)$job);
            }

            $this->info("Sent alerts for {$failedJobs->count()} failed jobs");
        } else {
            $this->info("No failed jobs in the last hour");
        }

        return 0;
    }
}
