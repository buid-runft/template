<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $filename = 'db-backup-' . now()->format('Y-m-d-H-i-s') . '.sql';
        $path = "backups/database/{$filename}";

        // ใช้ mysqldump หรือ pg_dump ขึ้นอยู่กับ database
        $database = config('database.default');
        $config = config("database.connections.{$database}");

        $command = match($database) {
            'mysql' => "mysqldump --host={$config['host']} --port={$config['port']} --user={$config['username']} --password={$config['password']} {$config['database']} > " . storage_path("app/{$path}"),
            'pgsql' => "pg_dump --host={$config['host']} --port={$config['port']} --username={$config['username']} --dbname={$config['database']} --file=" . storage_path("app/{$path}"),
            default => throw new \Exception('Database type not supported for backup'),
        };

        $exitCode = shell_exec($command . ' 2>&1; echo $?');

        if (intval($exitCode) !== 0) {
            \Log::error('Database backup failed', ['command' => $command]);
            throw new \Exception('Database backup failed');
        }

        \Log::info('Database backup completed', ['file' => $path]);
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('Database backup job failed', [
            'error' => $exception->getMessage(),
        ]);
    }
}
