<?php

namespace App\Jobs;

use App\Services\System\AlertService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FailedJobAlertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected array $jobData
    ) {}

    public function handle(AlertService $alertService): void
    {
        $alertService->sendFailedJobAlert($this->jobData);
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('FailedJobAlertJob failed to send alert', [
            'job_data' => $this->jobData,
            'error' => $exception->getMessage(),
        ]);
    }
}
