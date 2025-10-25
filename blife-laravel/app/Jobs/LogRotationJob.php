<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class LogRotationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $currentLog = 'logs/laravel-' . now()->format('Y-m-d') . '.log';
        $archiveLog = 'logs/archive/laravel-' . now()->subDay()->format('Y-m-d') . '.log';

        if (Storage::exists($currentLog)) {
            Storage::move($currentLog, $archiveLog);
            \Log::info('Log rotated successfully');
        }
    }
}
