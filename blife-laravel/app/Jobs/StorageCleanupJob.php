<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class StorageCleanupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // ล้างไฟล์ชั่วคราว
        $tempFiles = Storage::files('temp');
        foreach ($tempFiles as $file) {
            $lastModified = Storage::lastModified($file);
            $daysOld = now()->diffInDays($lastModified);

            if ($daysOld > 7) { // ล้างไฟล์ที่เก่ากว่า 7 วัน
                Storage::delete($file);
                \Log::info('Cleaned up temp file', ['file' => $file]);
            }
        }

        // ล้างไฟล์ log เก่า
        $this->cleanupLogs();
    }

    protected function cleanupLogs(): void
    {
        $logFiles = Storage::files('logs');
        foreach ($logFiles as $file) {
            $lastModified = Storage::lastModified($file);
            $daysOld = now()->diffInDays($lastModified);

            if ($daysOld > config('backup.retention_days', 30)) {
                Storage::delete($file);
                \Log::info('Cleaned up old log file', ['file' => $file]);
            }
        }
    }
}
