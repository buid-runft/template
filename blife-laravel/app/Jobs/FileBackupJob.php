<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Zip;

class FileBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $date = now()->format('Y-m-d-H-i-s');
        $backupPath = "backups/files/files-backup-{$date}.zip";

        $importantPaths = config('backup.files.important_directories', [
            'storage/app/public/products',
            'storage/app/public/stores',
            'storage/app/private/documents',
        ]);

        $zip = new \ZipArchive();
        $zipPath = storage_path("app/{$backupPath}");

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            foreach ($importantPaths as $path) {
                $this->addFilesToZip($zip, $path);
            }
            $zip->close();

            \Log::info('File backup completed', ['file' => $backupPath]);
        } else {
            throw new \Exception('Cannot create backup zip file');
        }
    }

    protected function addFilesToZip(\ZipArchive $zip, string $folder): void
    {
        $files = Storage::allFiles($folder);
        foreach ($files as $file) {
            $zip->addFromString($file, Storage::get($file));
        }
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('File backup job failed', [
            'error' => $exception->getMessage(),
        ]);
    }
}
